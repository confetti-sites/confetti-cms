package service

import (
	"fmt"
	"image"
	"image/jpeg"
	"image/png"
	"os"
	"path/filepath"
	"src/config"
	"strings"

	"golang.org/x/image/webp"
)

type SubImager interface {
	SubImage(r image.Rectangle) image.Image
}

type CropImageOptions struct {
	Height int `json:"height"`
	Width  int `json:"width"`
	X      int `json:"x"`
	Y      int `json:"y"`
}

func CropImage(originPath string, options CropImageOptions) (image.Image, string, error) {
	format := ""
	originalFile, err := os.Open(filepath.Join(config.Path.Storage, originPath))
	if err != nil {
		return nil, format, err
	}
	defer originalFile.Close()

	originalImage, format, err := decodeImage(originalFile)
	if err != nil {
		return nil, format, fmt.Errorf("failed to crop image: %w", err)
	}

	cropSize := image.Rect(options.X, options.Y, options.X+options.Width, options.Y+options.Height)
	croppedImage := originalImage.(SubImager).SubImage(cropSize)

	return croppedImage, format, nil
}

func decodeImage(file *os.File) (image.Image, string, error) {
	ext := strings.ToLower(filepath.Ext(file.Name()))
	switch ext {
	case ".png":
		img, err := png.Decode(file)
		return img, "png", err
	case ".jpeg", ".jpg":
		img, err := jpeg.Decode(file)
		return img, "jpeg", err
	case ".webp":
		img, err := webp.Decode(file)
		return img, "webp", err
	default:
		return nil, ext, fmt.Errorf("unsupported image format: %s", ext)
	}
}
