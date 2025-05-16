package http

import (
	"bytes"
	"github.com/matryer/is"
	net "net/http"
	"net/http/httptest"
	"src/cmd/api/command"
	"src/internal/auth"
	"src/internal/pkg/handler"
	"testing"
)

var imageStore = handler.GetRoute(command.ApiRoutes, "POST /images")

func Test_store_empty_images_empty(t *testing.T) {
	// Given
	i := is.New(t)
	request := httptest.NewRequest(net.MethodGet, "/images", bytes.NewBufferString("{\"data\": []}"))
	request.Header.Set("Content-Type", "application/json")
	request = auth.MockRequest(request, []auth.Permission{{Id: "/images/store"}})
	response := httptest.NewRecorder()

	// When
	handler.HandleApiRoute(response, request, imageStore)
	result := response.Result()

	// Then
	i.Equal(result.StatusCode, net.StatusUnsupportedMediaType)
}

func Test_store_images_but_unauthorized(t *testing.T) {
	// Given
	i := is.New(t)
	request := httptest.NewRequest(net.MethodGet, "/images", bytes.NewBufferString("{\"data\": []}"))
	request = auth.MockRequest(request, []auth.Permission{{Id: "/images/index"}})
	response := httptest.NewRecorder()

	// When
	handler.HandleApiRoute(response, request, imageStore)
	result := response.Result()

	// Then
	i.Equal(result.StatusCode, net.StatusUnauthorized)
}
