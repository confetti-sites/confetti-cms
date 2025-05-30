package service

import (
	"fmt"
	"io"
	"os"
	"path/filepath"
)

func SaveOriginalImage(file io.Reader, oldName string, storageDir string, id string) (string, error) {
	// Construct the full path to save the file
	saveDir := filepath.Join(storageDir, id)

	// Create the directory if it does not exist
	err := os.MkdirAll(saveDir, os.ModePerm)
	if err != nil {
		return "", fmt.Errorf("failed to create directory: %w", err)
	}

	// Create the new file name with .original inserted
	newName := GetSourcePath(filepath.Base(oldName), "original")

	// Create the destination file path
	destFilePath := filepath.Join(saveDir, newName)

	// Open the destination file
	destFile, err := os.Create(destFilePath)
	if err != nil {
		return "", fmt.Errorf("failed to create file: %w", err)
	}
	defer destFile.Close()

	// Copy the contents of the original file to the destination file
	_, err = io.Copy(destFile, file)
	if err != nil {
		return "", fmt.Errorf("failed to copy file: %w", err)
	}

	// Return the details of the saved file
	return filepath.Join(id, newName), nil
}
