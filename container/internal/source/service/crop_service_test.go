package service

import (
	"github.com/matryer/is"
	"path/filepath"
	"src/config"
	"testing"
)

// Before -> after
var extentions = map[string]string{
	"jpeg": "jpeg",
	"jpg":  "jpeg",
	"png":  "png",
	"webp": "webp",
}

func Test_crop_image_all_extentions(t *testing.T) {
	config.Path.Storage = filepath.Join(config.Path.Base, "test_mock")
	for fromExtention, reconisedAsExtention := range extentions {
		// Given
		setUpCropTest(t.Name())
		println("+++ RUN variation: " + fromExtention)
		mockFile := "/pinguin." + fromExtention

		// When
		image, format, err := CropImage(
			mockFile,
			CropImageOptions{
				Height: 100,
				Width:  200,
				X:      3,
				Y:      4,
			},
		)

		// Then
		i := is.New(t)
		i.NoErr(err)
		i.Equal(reconisedAsExtention, format)
		i.Equal(203, image.Bounds().Max.X)
		i.Equal(104, image.Bounds().Max.Y)
	}
}
