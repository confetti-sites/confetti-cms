package unit

import (
	"src/internal/source/service"
	"testing"

	"github.com/matryer/is"
)

func Test_get_minature_source_smaller_than_original_cropped(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		FromWidth:    60,
		FromHeight:   50,
	}

	// When
	result := service.GetMiniatureSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(2, len(result))
	i.Equal("image.minature.jpg", result[0].Name)
	i.Equal(service.MediaMiniature, result[0].Media)
	i.Equal(60, result[0].Crop.Width)
	i.Equal(50, result[0].Crop.Height)
	i.Equal("image.minature_2x.jpg", result[1].Name)
	i.Equal(service.MediaMiniature2x, result[1].Media)
	i.Equal(60, result[1].Crop.Width)
	i.Equal(50, result[1].Crop.Height)
}

func Test_get_minature_target_smaller_than_original_cropped(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		FromWidth:    4000,
		FromHeight:   3000,
	}

	// When
	result := service.GetMiniatureSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(2, len(result))
	i.Equal("image.minature.jpg", result[0].Name)
	i.Equal(service.MediaMiniature, result[0].Media)
	i.Equal(200, result[0].Crop.Width)
	i.Equal(150, result[0].Crop.Height)
	i.Equal("image.minature_2x.jpg", result[1].Name)
	i.Equal(service.MediaMiniature2x, result[1].Media)
	i.Equal(400, result[1].Crop.Width)
	i.Equal(300, result[1].Crop.Height)
}

func Test_get_minature_source_smaller_than_double_original_cropped(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		// ratio 3:4
		FromWidth:  300,
		FromHeight: 225,
	}

	// When
	result := service.GetMiniatureSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(2, len(result))
	i.Equal("image.minature.jpg", result[0].Name)
	i.Equal(service.MediaMiniature, result[0].Media)
	i.Equal(200, result[0].Crop.Width)
	i.Equal(150, result[0].Crop.Height)
	i.Equal("image.minature_2x.jpg", result[1].Name)
	i.Equal(service.MediaMiniature2x, result[1].Media)
	i.Equal(false, result[1].SameAsStandard)
	i.Equal(300, result[1].Crop.Width)
	i.Equal(225, result[1].Crop.Height)
}

func Test_get_minature_source_bigger_than_double_original_cropped(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		FromWidth:    800,
		FromHeight:   600,
	}

	// When
	result := service.GetMiniatureSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(2, len(result))
	i.Equal("image.minature.jpg", result[0].Name)
	i.Equal("image.minature_2x.jpg", result[1].Name)
	i.Equal(service.MediaMiniature2x, result[1].Media)
	i.Equal(false, result[1].SameAsStandard)
	i.Equal(400, result[1].Crop.Width)
	i.Equal(300, result[1].Crop.Height)
}
