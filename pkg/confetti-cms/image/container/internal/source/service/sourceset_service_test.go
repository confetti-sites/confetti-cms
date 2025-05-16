package service

import (
	"log"
	"os"
	"path/filepath"
	"src/config"
	"testing"

	"github.com/matryer/is"
)

func setUpCropTest(test string) {
	config.Path.Storage = filepath.Join(config.Path.Base, "test_mock")
	dir := filepath.Join(config.Path.ResultStorage, test)
	// Ensure the directory is removed if it exists
	if err := os.RemoveAll(dir); err != nil {
		log.Fatalf("Failed to remove directory %s: %v", dir, err)
	}
}

func Test_cutout_file_name_origin(t *testing.T) {
	result := GetSourcePath("result/dir/pinguin.original.jpeg", "")

	i := is.New(t)
	i.Equal("result/dir/pinguin.jpeg", result)
}

func Test_cutout_file_name_webp(t *testing.T) {
	result := GetSourcePath("result/dir/pinguin.original.webp", "")

	i := is.New(t)
	i.Equal("result/dir/pinguin.jpeg", result)
}

func Test_cutout_file_name_mobile(t *testing.T) {
	result := GetSourcePath("result/dir/pinguin.original.jpeg", "mobile")

	i := is.New(t)
	i.Equal("result/dir/pinguin.mobile.jpeg", result)
}

func Test_cutout_file_name_miniature(t *testing.T) {
	result := GetSourcePath("result/dir/pinguin.miniature.jpeg", "miniature")

	i := is.New(t)
	i.Equal("result/dir/pinguin.miniature.jpeg", result)
}

func Test_cutout_file_add_original(t *testing.T) {
	result := GetSourcePath("pinguin.webp", "original")

	i := is.New(t)
	i.Equal("pinguin.original.jpeg", result)
}
