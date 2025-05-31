package config

import (
	"os"
	"path/filepath"
)

// Path contains a list of all paths you can use in your application.
var Path = struct {
	Base, ResultStorage, Storage string
}{
	/*
		|--------------------------------------------------------------------------
		| Base Path
		|--------------------------------------------------------------------------
		|
		| The base path is the fully qualified path to the root of your project.
		| Feel free to adjust this so that it fits to your needs.
		|
	*/
	Base: basePath(),
	Storage:       env("STORAGE_PATH", "/var/storage"),
	ResultStorage: filepath.Join(basePath(), "test_result"),
	//	Resource:                     filepath.Join(basePath(), "resources"),
	//	SharedResource:               env.String("SHARED_RESOURCE_PATH"),
	//	SharedResourceCurrentService: filepath.Join(env.String("SHARED_RESOURCE_PATH"), env.String("APP_SERVICE")),
}

func basePath() string {
	root, _ := os.Getwd()
	return root
}
