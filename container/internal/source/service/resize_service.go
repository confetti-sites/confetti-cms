package service

import (
	"errors"
	"image"
	"image/jpeg"
	"image/png"
	"os"
	"path/filepath"
	"src/config"

	"github.com/HugoSmits86/nativewebp"
	"golang.org/x/image/draw"
)

// ResizeSource resizes the source image based on the dimensions specified in the source entity.
func ResizeSource(cropped image.Image, format string, source Source) error {
	// Resize the image
	newImage := resizeImage(cropped, source.Crop.Width, source.Crop.Height)

	// Create the output file
	outFile, err := os.Create(filepath.Join(config.Path.Storage, source.Name))
	if err != nil {
		return err
	}
	defer outFile.Close()

	// Encode and save the output image
	switch format {
	case "jpeg", "jpg":
		err = jpeg.Encode(outFile, newImage, &jpeg.Options{Quality: 80})
	case "png":
		err = png.Encode(outFile, newImage)
	case "webp":
		err = nativewebp.Encode(outFile, newImage, nil)
	default:
		return errors.New("unsupported image format")
	}

	return err
}

// resizeImage scales the input image to the specified width and height using interpolation.
func resizeImage(img image.Image, width, height int) image.Image {
	// Create a new empty image with the desired dimensions
	dst := image.NewRGBA(image.Rect(0, 0, width, height))
	// Scale the image down
	draw.CatmullRom.Scale(dst, dst.Rect, img, img.Bounds(), draw.Over, nil)

	return dst
}
