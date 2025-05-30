package source

import (
	"encoding/json"
	"errors"
	"fmt"
	"image"
	"net/http"
	"src/internal/pkg/handler"
	"src/internal/source/service"
	"sync"
)

type StoreBody struct {
	Id          string `json:"id"`
	Original    string `json:"original"`
	TargetWidth int    `json:"target_width"`
	Height      int    `json:"height"`
	Width       int    `json:"width"`
	X           int    `json:"x"`
	Y           int    `json:"y"`
}

func StoreRequest(request *http.Request) (StoreBody, error) {
	var sourceBody StoreBody

	// Parse the JSON body
	decoder := json.NewDecoder(request.Body)
	err := decoder.Decode(&sourceBody)
	if err != nil {
		// Check if the error is of type *json.UnmarshalTypeError
		var typeErr *json.UnmarshalTypeError
		if errors.As(err, &typeErr) {
			// Construct a detailed error message
			errorMsg := fmt.Sprintf("Invalid request payload: field '%s' of type '%s' received value '%s'",
				typeErr.Field, typeErr.Type, typeErr.Value)
			return StoreBody{}, handler.NewUserError(errorMsg, http.StatusUnprocessableEntity)
		}
		return StoreBody{}, handler.NewUserError("Invalid request payload: "+err.Error(), http.StatusUnprocessableEntity)
	}

	// Validate required fields
	if sourceBody.Id == "" {
		return StoreBody{}, handler.NewUserError("Id not given", http.StatusUnprocessableEntity)
	}
	if sourceBody.Original == "" {
		return StoreBody{}, handler.NewUserError("Original not given", http.StatusUnprocessableEntity)
	}
	if sourceBody.Height == 0 {
		return StoreBody{}, handler.NewUserError("Height not given", http.StatusUnprocessableEntity)
	}
	if sourceBody.Width == 0 {
		return StoreBody{}, handler.NewUserError("Width not given", http.StatusUnprocessableEntity)
	}
	// sourceBody.X, default 0
	// sourceBody.Y, default 0

	// Use cropped width if TargetWidth is not set
	if sourceBody.TargetWidth == 0 {
		sourceBody.TargetWidth = sourceBody.Width
	}

	return sourceBody, nil
}

// Store crops and resizes the original image to multiple images
func Store(response http.ResponseWriter, request *http.Request) error {
	// First, validate the request
	payload, err := StoreRequest(request)
	if err != nil {
		return err
	}

	// Size the image to the desired shape, but in the same quality
	croppingOptions := service.CropImageOptions{
		Height: payload.Height,
		Width:  payload.Width,
		X:      payload.X,
		Y:      payload.Y,
	}
	cropped, format, err := service.CropImage(payload.Original, croppingOptions)
	if err != nil {
		return handler.NewSystemError(err, "Failed to crop image")
	}

	// Get all the desired sizes
	options := service.GetSourceSetOptions{
		StandardName: payload.Original,
		FromHeight:   payload.Height,
		FromWidth:    payload.Width,
		TargetWidth:  payload.TargetWidth,
	}
	sourceSet := service.SourceSet{}
	sourceSet = append(sourceSet, service.GetBigSourceSet(options)...)
	sourceSet = append(sourceSet, service.GetMobileSourceSet(options)...)
	sourceSet = append(sourceSet, service.GetMiniatureSourceSet(options)...)
	sourceSet = append(sourceSet, service.GetStandardSourceSet(options)...)

	// Resize the sources asynchronously
	err = resizeSources(cropped, format, sourceSet)
	if err != nil {
		return handler.NewSystemError(err, "Failed to resize sources")
	}

	// Return a successful response with a status of 201 Created
	return handler.ToJson(response, sourceSet, http.StatusCreated)
}

func resizeSources(cropped image.Image, format string, sourceSet service.SourceSet) error {
	var wg sync.WaitGroup
	var mu sync.Mutex
	errors := make([]error, 0)

	// Resize the cropped image to multiple sources with different sizes
	for _, source := range sourceSet {
		// If the image is the same as the standard, we don't need to resize the image
		if source.SameAsStandard {
			continue
		}
		wg.Add(1)
		go func(source service.Source) {
			defer wg.Done()
			err := service.ResizeSource(cropped, format, source)
			if err != nil {
				mu.Lock()
				errors = append(errors, err)
				mu.Unlock()
			}
		}(source)
	}

	wg.Wait()

	if len(errors) > 0 {
		errorMessages := "Errors occurred during resizing:\n"
		for _, err := range errors {
			errorMessages += err.Error() + "\n"
		}
		return fmt.Errorf(errorMessages)
	}

	return nil
}
