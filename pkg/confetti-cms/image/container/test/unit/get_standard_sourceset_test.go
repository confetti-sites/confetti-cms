package unit

import (
	"src/internal/source/service"
	"testing"

	"github.com/matryer/is"
)

func Test_get_standard_sourceset_target_bigger_than_from(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		FromWidth:    1400,
		FromHeight:   1050,
		TargetWidth:  2000,
	}

	// When
	result := service.GetStandardSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(1, len(result))
	i.Equal("image.jpg", result[0].Name)
	i.Equal(1400, result[0].Crop.Width)
	i.Equal(1050, result[0].Crop.Height)
	i.Equal(false, result[0].SameAsStandard)
	i.Equal(service.MediaStandard, result[0].Media)
}

func Test_get_standard_sourceset_target_smaller_than_from(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		FromWidth:    1400,
		FromHeight:   1050,
		TargetWidth:  1000,
	}

	// When
	result := service.GetStandardSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(1, len(result))
	i.Equal(1000, result[0].Crop.Width)
	i.Equal(750, result[0].Crop.Height)
}
