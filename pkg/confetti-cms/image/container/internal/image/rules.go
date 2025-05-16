package image

import (
	"fmt"
	"net/http"
	"strings"
)

type ContentType struct {
	In []string
}

func (r ContentType) Verify(headers http.Header) error {
	contentType := headers.Get("Content-Type")
	if contentType == "" {
		return fmt.Errorf("Content-Type header is missing")
	}

	// Extract the main type and subtype, ignoring any parameters
	mainType := strings.TrimSpace(strings.Split(contentType, ";")[0])

	for _, allowedType := range r.In {
		if mainType == allowedType {
			return nil
		}
	}

	return fmt.Errorf("Content-Type %s is not allowed", contentType)
}
