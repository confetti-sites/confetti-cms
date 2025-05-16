package unit

import (
	"src/internal/source/service"
	"testing"

	"github.com/matryer/is"
)

func Test_get_big_source_smaller_than_mobile(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		FromWidth:    600,
		TargetWidth:  700,
	}

	// When
	result := service.GetBigSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(0, len(result))
}

func Test_get_big_source_smaller_than_target_width(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		FromWidth:    1400,
		FromHeight:   1050,
		TargetWidth:  2000,
	}

	// When
	result := service.GetBigSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(1, len(result))
	i.Equal("image.jpg", result[0].Name)
	i.Equal(service.MediaBig, result[0].Media)
	i.Equal(1400, result[0].Crop.Width)
	i.Equal(1050, result[0].Crop.Height)
	i.Equal(true, result[0].SameAsStandard)
}

func Test_get_big_source_smaller_than_double_target_width(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		// ratio 3:4
		FromWidth:   1400,
		FromHeight:  1050,
		TargetWidth: 1000,
	}

	// When
	result := service.GetBigSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(2, len(result))
	i.Equal("image.jpg", result[0].Name)
	i.Equal(service.MediaBig, result[0].Media)
	i.Equal(1000, result[0].Crop.Width)
	i.Equal(750, result[0].Crop.Height)
	i.Equal(true, result[0].SameAsStandard)
	i.Equal("image.2x.jpg", result[1].Name)
	i.Equal(service.MediaBig2x, result[1].Media)
	i.Equal(1400, result[1].Crop.Width)
	i.Equal(1050, result[1].Crop.Height)
	i.Equal(false, result[1].SameAsStandard)
}

func Test_get_big_source_bigger_than_double_target_width(t *testing.T) {
	// Given
	options := service.GetSourceSetOptions{
		StandardName: "image.jpg",
		// ratio 3:4
		FromWidth:   4000,
		FromHeight:  3000,
		TargetWidth: 1000,
	}

	// When
	result := service.GetBigSourceSet(options)

	// Then
	i := is.New(t)
	i.Equal(2, len(result))
	i.Equal("image.jpg", result[0].Name)
	i.Equal(service.MediaBig, result[0].Media)
	i.Equal("image.2x.jpg", result[1].Name)
	i.Equal(service.MediaBig2x, result[1].Media)
	i.Equal(2000, result[1].Crop.Width)
	i.Equal(1500, result[1].Crop.Height)
	i.Equal(false, result[1].SameAsStandard)
}
