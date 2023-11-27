<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDU6AKAXtutXqOJMwvJD1rrDZZ4zrIfJc&libraries=places">
</script>
<script>
    const imgSource = `{{ isset($branch) ? $branch->image?->path_with_original_size : null }}`
    console.log(imgSource);
    const file = FilePond.create(document.querySelector('input[name=image]'), {
        imagePreviewHeight: 170,
        storeAsFile: true,
        files: imgSource ? [imgSource] : [],
        labelIdle: 'Kéo thả file hoặc <span class="filepond--label-action"> Chọn </span>'
    })

    function initMap() {
        var myLatLng = {
            lat: $('[name=google_latitude]').val() ? parseFloat($('[name=google_latitude]').val()) : 37.7749,
            lng: $('[name=google_longitude]').val() ? parseFloat($('[name=google_longitude]').val()) : -122.4194,
        }; // set the center of the map to San Francisco

        var map = new google.maps.Map(document.getElementById('google-map-wrapper'), {
            zoom: 20,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
        });
        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.LEFT_TOP].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });

        let markers = [];

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();

            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };

                // Create a marker for each place.
                markers.push(
                    new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location,
                    })
                );
                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                $('[name=google_latitude]').val(lat)
                $('[name=google_longitude]').val(lng)
            });
            map.fitBounds(bounds);
        });
    }
    $('form').ajaxForm({
        beforeSend: () => {
            $('.submit-btn').loading()
        },
        data: {
            image: file.getFile(1),
            phoneImage: file.getFile(1)
        },
        dataType: 'json',
        error: (err) => {
            $('.submit-btn').loading(false)
        },
        success: (res) => {
            toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
            setTimeout(() => {
                window.location.href = res.data.url
            }, 1000);
        }
    })
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaJXP838pFvEowdo9LEbF7CQBQZbQzQp0&libraries=places&callback=initMap">
</script>
