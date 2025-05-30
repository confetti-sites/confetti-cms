package image

import (
	"net/http"
	"src/config"
	"src/internal/pkg/handler"
	"src/internal/source/service"
)

const maxMemory = 32 << 20 // 32 MB

func StoreRequest(request *http.Request) error {
	// Validate content type
	err := ContentType{In: []string{"multipart/form-data"}}.Verify(request.Header)
	if err != nil {
		return handler.UserError{HttpStatus: http.StatusUnsupportedMediaType}
	}

	return nil
}

// Store handles the actual image storing process
func Store(response http.ResponseWriter, request *http.Request) error {
	// First, validate the request
	err := StoreRequest(request)
	if err != nil {
		return err
	}

	// Parse the multipart form data with a maximum memory limit
	err = request.ParseMultipartForm(maxMemory)
	if err != nil {
		// Return an error if parsing fails
		return handler.NewSystemError(err, "ag84r3g")
	}
	if request.MultipartForm == nil {
		// Return an error if the MultipartForm is nil
		return handler.NewUserError("MultipartForm is nil", http.StatusBadRequest)
	}

	// Iterate over each file in the multipart form
	result := []map[string]string{}
	for id, _ := range request.MultipartForm.File {
		// Retrieve the file from the form
		in, header, err := request.FormFile(id)
		if err != nil {
			// Return an error if retrieving the file fails
			return handler.NewSystemError(err, "j905awg3")
		}
		file, err := header.Open()
		if err != nil {
			// Close the input file handle and return an error if opening the file fails
			in.Close()
			return handler.NewSystemError(err, "g9ji3r4")
		}

		// Save the image file to the specified directory
		path, err := service.SaveOriginalImage(file, header.Filename, config.Path.Storage, id)
		if err != nil {
			// Close the file handles and return an error if saving the file fails
			file.Close()
			in.Close()
			return handler.NewSystemError(err, "8uh56")
		}
		result = append(result, map[string]string{
			"original": path,
		})

		// Close the file handles inside the loop (do not defer)
		file.Close()
		in.Close()
	}

	return handler.ToJson(response, result, http.StatusCreated)
}
