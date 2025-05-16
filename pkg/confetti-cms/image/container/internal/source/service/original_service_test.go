package service

import (
	"github.com/matryer/is"
	"os"
	"path/filepath"
	"src/config"
	"testing"
)

// width 1024
const pinquin = "pinguin.jpeg"

var pinquinPath = filepath.Join(config.Path.Base, "test_mock", pinquin)

func Test_save_image(t *testing.T) {
	// Given
	image := getFile(t, pinquinPath)
	defer image.Close()

	// When
	_, err := SaveOriginalImage(image, pinquinPath, config.Path.ResultStorage, "Test_save_image/model/banner_image")

	// Then
	i := is.New(t)
	i.NoErr(err)
	// Assert that the image exists at the expected location
	expectedFilePath := filepath.Join(config.Path.ResultStorage, "Test_save_image/model/banner_image/pinguin.original.jpeg")
	_, err = os.Stat(expectedFilePath)
	i.NoErr(err) // Check if the file exists without any error
}

// Read the image file from the specified path
func getFile(t *testing.T, path string) *os.File {
	image, err := os.Open(path)
	if err != nil {
		t.Fatalf("failed to open image file: %v", err)
	}
	return image
}
