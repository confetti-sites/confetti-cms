package image

import (
	"fmt"
	"io/ioutil"
	net "net/http"
	"os"
	"path/filepath"
	"src/config"
	"src/internal/pkg/handler"
	"strings"
)

func ShowRequest(request *net.Request) (error, string) {
	// Remove the container url prefix
	relativeLocation := strings.TrimPrefix(request.RequestURI, "/conf_api/confetti-cms/media")
	// Remove the endoint
	relativeLocation = strings.TrimPrefix(relativeLocation, "/images")

	return nil, relativeLocation
}

// Show handles the actual image storing process
func Show(response net.ResponseWriter, request *net.Request) error {
	// First, validate the request
	err, relativeLocation := ShowRequest(request)
	if err != nil {
		return err
	}

	filename := filepath.Join(config.Path.Storage, relativeLocation)

	// Set the correct headers and write the image data to the response
	return download(response, filename)
}

func download(response net.ResponseWriter, filename string) error {
	info, err := os.Stat(filename)
	if os.IsNotExist(err) {
		println("Error: Image not found. Filename: ", filename+". Error: ", err)
		return handler.NewUserError("Image not found", net.StatusNotFound)
	}
	if err != nil {
		return handler.NewSystemError(err, "gihd34")
	}
	if info.IsDir() {
		return handler.NewUserError(fmt.Sprintf("can't download a directory %s", filename), net.StatusUnprocessableEntity)
	}
	content, err := ioutil.ReadFile(filename)
	if err != nil {
		return err
	}
	mime, ok := imageMimeByExtension(info.Name())
	if ok {
		response.Header().Set("Content-Type", mime)
	}

	response.WriteHeader(net.StatusOK)
	_, err = response.Write(content)
	if err != nil {
		return handler.NewSystemError(err, "hgrioen")
	}
	return nil
}

var mapImageMimeExtension = map[string]string{
	"image/svg+xml":             ".svg",
	"image/png":                 ".png",
	"image/jpeg":                ".jpg",
	"image/jp2":                 ".jp2",
	"image/jpx":                 ".jpf",
	"image/jpm":                 ".jpm",
	"image/bpg":                 ".bpg",
	"image/gif":                 ".gif",
	"image/webp":                ".webp",
	"image/tiff":                ".tiff",
	"image/bmp":                 ".bmp",
	"image/x-icon":              ".ico",
	"image/x-icns":              ".icns",
	"image/vnd.adobe.photoshop": ".psd",
	"image/heic":                ".heic",
	"image/heic-sequence":       ".heic",
	"image/heif":                ".heif",
	"image/heif-sequence":       ".heif",
	"image/vnd.djvu":            ".djvu",
	"image/vnd.dwg":             ".dwg",
}

func imageMimeByExtension(filename string) (string, bool) {
	if filename == "" {
		return "", false
	}
	parts := strings.Split(filename, ".")
	inputExtension := "." + parts[len(parts)-1]
	for mime, extension := range mapImageMimeExtension {
		if extension == inputExtension {
			return mime, true
		}
	}
	return "", false
}
