package ping

import (
	"github.com/matryer/is"
	"net/http"
	"net/http/httptest"
	"src/cmd/api/command"
	"src/internal/pkg/handler"
	"testing"
)

var pingShow = handler.GetRoute(command.ApiRoutes, "GET /ping")

func Test_show_ping_endpoint(t *testing.T) {
	// Given
	i := is.New(t)
	request := httptest.NewRequest(http.MethodGet, "/ping", nil)
	response := httptest.NewRecorder()

	// When
	handler.HandleApiRoute(response, request, pingShow)
	result := response.Result()

	// Then
	i.Equal(result.StatusCode, http.StatusOK)
	i.Equal(handler.GetBody(result), "pong")
}
