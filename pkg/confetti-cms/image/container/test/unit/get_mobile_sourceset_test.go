package unit

import (
	"src/internal/source/service"
	"testing"

	"github.com/matryer/is"
)

func Test_get_mobile_source_smaller_than_original_cropped(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		FromWidth:    600,
		FromHeight:   450,
		TargetWidth:  5000,
	}

	// When
	result := service.GetMobileSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(0, len(result))
}

func Test_get_mobile_target_smaller_than_original_cropped(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		FromWidth:    4000,
		FromHeight:   3000,
		TargetWidth:  600,
	}

	// When
	result := service.GetMobileSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(2, len(result))
	i.Equal("image.mobile.jpg", result[0].Name)
	i.Equal(service.MediaMobile, result[0].Media)
	i.Equal(600, result[0].Crop.Width)
	i.Equal(450, result[0].Crop.Height)
	i.Equal("image.mobile_2x.jpg", result[1].Name)
	i.Equal(service.MediaMobile2x, result[1].Media)
	i.Equal(1200, result[1].Crop.Width)
	i.Equal(900, result[1].Crop.Height)
}

func Test_get_mobile_source_smaller_than_double_original_cropped(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		// ratio 3:4
		FromWidth:   800,
		FromHeight:  600,
		TargetWidth: 5000,
	}

	// When
	result := service.GetMobileSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(2, len(result))
	i.Equal("image.mobile.jpg", result[0].Name)
	i.Equal(service.MediaMobile, result[0].Media)
	i.Equal(640, result[0].Crop.Width)
	i.Equal(480, result[0].Crop.Height)
	i.Equal("image.jpg", result[1].Name)
	i.Equal(service.MediaMobile2x, result[1].Media)
	i.Equal(true, result[1].SameAsStandard)
	i.Equal(800, result[1].Crop.Width)
	i.Equal(600, result[1].Crop.Height)
}

func Test_get_mobile_source_bigger_than_double_original_cropped(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		FromWidth:    1400,
		FromHeight:   1050,
		TargetWidth:  5000,
	}

	// When
	result := service.GetMobileSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(2, len(result))
	i.Equal("image.mobile.jpg", result[0].Name)
	i.Equal("image.mobile_2x.jpg", result[1].Name)
	i.Equal(service.MediaMobile2x, result[1].Media)
	i.Equal(false, result[1].SameAsStandard)
	i.Equal(1280, result[1].Crop.Width)
	i.Equal(960, result[1].Crop.Height)
}
