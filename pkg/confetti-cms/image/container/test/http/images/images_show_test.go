package http

import (
	"github.com/matryer/is"
	net "net/http"
	"net/http/httptest"
	"path/filepath"
	"src/cmd/api/command"
	"src/config"
	"src/internal/pkg/handler"
	"testing"
)

var imageShow = handler.GetRoute(command.ApiRoutes, "GET /images/")

func Test_show_unkown_image(t *testing.T) {
	// Given
	i := is.New(t)
	request := httptest.NewRequest(net.MethodGet, "/images/homepage/banner/not_found.jpg", nil)
	response := httptest.NewRecorder()

	// When
	handler.HandleApiRoute(response, request, imageShow)
	result := response.Result()

	// Then
	i.Equal(result.StatusCode, net.StatusNotFound)
}

func Test_show_image(t *testing.T) {
	// Given
	config.Path.Storage = filepath.Join(config.Path.Base, "../mock")
	i := is.New(t)
	request := httptest.NewRequest(net.MethodGet, "/images/pinguin.jpeg", nil)
	response := httptest.NewRecorder()

	// When
	handler.HandleApiRoute(response, request, imageShow)
	result := response.Result()

	// Then
	i.Equal(result.StatusCode, net.StatusOK)
}

func Test_show_image_by_conf_api(t *testing.T) {
	// Given
	config.Path.Storage = filepath.Join(config.Path.Base, "../mock")
	i := is.New(t)
	request := httptest.NewRequest(net.MethodGet, "/conf_api/confetti-cms/media/images/pinguin.jpeg", nil)
	response := httptest.NewRecorder()

	// When
	handler.HandleApiRoute(response, request, imageShow)
	result := response.Result()

	// Then
	i.Equal(result.StatusCode, net.StatusOK)
}
