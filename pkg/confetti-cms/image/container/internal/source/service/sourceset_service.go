package service

import (
	"fmt"
	"path/filepath"
	"strings"
)

const mobileWidthSize = 640
const miniatureWidthSize = 200

const MediaBig2x = "big2x"
const MediaBig = "big"
const MediaMobile2x = "mobile2x"
const MediaMobile = "mobile"
const MediaMiniature = "miniature"
const MediaMiniature2x = "miniature2x"
const MediaStandard = "standard"

type Size struct {
	Height int `json:"height"`
	Width  int `json:"width"`
}

type Source struct {
	Name           string `json:"name"`
	SameAsStandard bool   `json:"-"`
	Crop           Size   `json:"size"`
	Media          string `json:"media"`
}

type SourceSet []Source

type GetSourceSetOptions struct {
	StandardName string
	FromHeight   int
	FromWidth    int
	TargetWidth  int
}

// GetStandardSourceSet return the formats with instructions to resize the image
func GetStandardSourceSet(o GetSourceSetOptions) SourceSet {
	result := SourceSet{}

	// If the from image is smaller than target width:
	width := o.FromWidth
	height := o.FromHeight
	// If the from image is bigger than target width x2, use the target width * 2
	if o.TargetWidth < o.FromWidth {
		width = o.TargetWidth
		height = getHeightByRatio(o.TargetWidth, getRatio(o))
	}
	result = append(result, Source{
		Name:  GetSourcePath(o.StandardName, ""),
		Media: MediaStandard,
		Crop: Size{
			Width:  width,
			Height: height,
		},
		SameAsStandard: false,
	})
	return result
}

// GetMobileSourceSet return the formats with instructions to resize the image
func GetMobileSourceSet(o GetSourceSetOptions) SourceSet {
	result := SourceSet{}
	// If the from image is smaller than the mobile width,
	// we use the from image. In that case, we don't add extra sources
	if o.FromWidth <= mobileWidthSize || (o.TargetWidth*2) <= mobileWidthSize {
		return result
	}
	ratio := getRatio(o)
	mobileTargetWidth := min(mobileWidthSize, o.TargetWidth)
	result = append(result, Source{
		Name:  GetSourcePath(o.StandardName, "mobile"),
		Media: MediaMobile,
		Crop: Size{
			Width:  mobileTargetWidth,
			Height: getHeightByRatio(mobileTargetWidth, ratio),
		},
	})
	// If the from image is smaller than the mobile width * 2,
	// we use the from image. We need both sources.
	if o.FromWidth <= (mobileWidthSize * 2) {
		return append(result, Source{
			Name:           GetSourcePath(o.StandardName, ""),
			Media:          MediaMobile2x,
			SameAsStandard: true,
			Crop: Size{
				Width:  o.FromWidth,
				Height: o.FromHeight,
			},
		})
	}

	return append(result, Source{
		Name:  GetSourcePath(o.StandardName, "mobile_2x"),
		Media: MediaMobile2x,
		Crop: Size{
			Width:  mobileTargetWidth * 2,
			Height: getHeightByRatio(mobileTargetWidth, ratio) * 2,
		},
	})
}

// GetMobileSourceSet return the formats with instructions to resize the image
func GetMiniatureSourceSet(o GetSourceSetOptions) SourceSet {
	result := SourceSet{}
	ratio := getRatio(o)
	minatureTargetWidth := min(miniatureWidthSize, o.FromWidth)
	result = append(result, Source{
		Name:  GetSourcePath(o.StandardName, "minature"),
		Media: MediaMiniature,
		Crop: Size{
			Width:  minatureTargetWidth,
			Height: getHeightByRatio(minatureTargetWidth, ratio),
		},
	})
	// If the from image is smaller than the miniature width * 2,
	// we use the from image. We need both sources.
	if o.FromWidth <= (miniatureWidthSize * 2) {
		return append(result, Source{
			Name:  GetSourcePath(o.StandardName, "minature_2x"),
			Media: MediaMiniature2x,
			Crop: Size{
				Width:  o.FromWidth,
				Height: o.FromHeight,
			},
		})
	}

	return append(result, Source{
		Name:  GetSourcePath(o.StandardName, "minature_2x"),
		Media: MediaMiniature2x,
		Crop: Size{
			Width:  minatureTargetWidth * 2,
			Height: getHeightByRatio(minatureTargetWidth, ratio) * 2,
		},
	})
}

// GetBigSourceSet return the formats with instructions to resize the image
func GetBigSourceSet(o GetSourceSetOptions) SourceSet {
	result := SourceSet{}
	// If the from image is smaller than the mobile width,
	// we use the from image. In that case, we don't add extra sources
	if o.FromWidth < mobileWidthSize {
		return result
	}

	// If the from image is is smaller than the target width
	// we only want to show the standard image
	if o.FromWidth <= (o.TargetWidth) {
		result = append(result, Source{
			Name:  GetSourcePath(o.StandardName, ""),
			Media: MediaBig,
			Crop: Size{
				Width:  o.FromWidth,
				Height: o.FromHeight,
			},
			SameAsStandard: true,
		})
		return result
	}

	// Now we first image is always the target size
	ratio := getRatio(o)
	result = append(result, Source{
		Name:  GetSourcePath(o.StandardName, ""),
		Media: MediaBig,
		Crop: Size{
			Width:  o.TargetWidth,
			Height: getHeightByRatio(o.TargetWidth, ratio),
		},
		SameAsStandard: true,
	})

	// If the from image is smaller than target width x2:
	width := o.FromWidth
	height := o.FromHeight
	// If the from image is bigger than target width x2, use the target width * 2
	if o.FromWidth > (o.TargetWidth * 2) {
		width = o.TargetWidth * 2
		height = getHeightByRatio(o.TargetWidth*2, ratio)
	}
	result = append(result, Source{
		Name:  GetSourcePath(o.StandardName, "2x"),
		Media: MediaBig2x,
		Crop: Size{
			Width:  width,
			Height: height,
		},
		SameAsStandard: false,
	})
	return result
}

func GetSourcePath(originName string, source string) string {
	// Extract the file name and extension
	ext := filepath.Ext(originName)
	name := strings.TrimSuffix(originName, ext)
	// Trim 'original' if present
	name = strings.TrimSuffix(name, ".original")
	if source != "" {
		source = "." + source
	}

	// Format the new filename
	return fmt.Sprintf("%s%s%s", name, source, ext)
}

func getHeightByRatio(width int, ratio float64) int {
	return int(float64(width) * ratio)
}

func getRatio(o GetSourceSetOptions) float64 {
	return float64(o.FromHeight) / float64(o.FromWidth)
}

// min returns the smaller of two integers.
func min(a, b int) int {
	if a < b {
		return a
	}
	return b
}
