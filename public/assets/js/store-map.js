function initMap() {
    if (document.querySelector("#wpm-app")) {
        const initStoreMapData = async () => {
            let currentIndex;
            const getBranches = async () => {
                const response = await $.get("/api/branches");
                return response.data;
            };
            const branches = await getBranches();
            await renderMap(branches);
            var myLatLng = {
                lat: branches[0].google_latitude,
                lng: branches[0].google_longitude,
            }; // set the center of the map to San Francisco

            var map = new google.maps.Map(
                document.getElementById("wpm-map-canvas"),
                {
                    zoom: 20,
                    center: myLatLng,
                }
            );
            new google.maps.Marker({
                position: {
                    lat: branches[0].google_latitude,
                    lng: branches[0].google_longitude,
                },
                map: map,
                title: "Hello World!",
            });

            $("body").on("click", ".wpm-store-li", function () {
                const branchId = $(this).attr("data-id");
                const branch = branches.find((b) => b.id == branchId);
                var newCenter = new google.maps.LatLng(
                    branch.google_latitude,
                    branch.google_longitude
                );
                map.setCenter(newCenter);
                map.setZoom(20);
                new google.maps.Marker({
                    position: {
                        lat: branch.google_latitude,
                        lng: branch.google_longitude,
                    },
                    map: map,
                    title: "Hello World!",
                });
            });
            infoWindow = new google.maps.InfoWindow();

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    currentIndex = pos;
                },
                () => {
                    handleLocationError(true, infoWindow, map.getCenter());
                }
            );

            function handleLocationError(
                browserHasGeolocation,
                infoWindow,
                pos
            ) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(
                    browserHasGeolocation
                        ? "Error: The Geolocation service failed."
                        : "Error: Your browser doesn't support geolocation."
                );
                infoWindow.open(map);
            }
            $("body").on("click", ".wpm-lnk-direction", function () {
                const branchId = $(this).attr("data-id");
                const branch = branches.find((b) => b.id == branchId);
                window
                    .open(
                        `https://www.google.com/maps/dir/?api=1&origin=${currentIndex.lat},${currentIndex.lng}&destination=${branch.google_latitude},${branch.google_longitude}`,
                        "_blank"
                    )
                    .focus();
            });
            $("body").on("change", "#wpm-t-switch", function (e) {
                const isOpen = $(this).is(":checked");
                if (isOpen) {
                    const tmp = branches.filter(
                        (branch) => branch.is_open === true
                    );
                    renderStoreList(tmp);
                    console.log(tmp);
                } else {
                    renderStoreList(branches);
                }
            });
            $('body').on('keyup', '#wpm-store-name', function() {
                const search = $(this).val()
                const temp = branches.filter(branch => branch.name.toLowerCase().indexOf(search.toLowerCase()) !== -1)
                renderStoreList(temp);
            })
        };
        const renderMap = (branches) => {
            $("#wpm-app").html(`
            <div class="wp-maps-cont wpm-locator-pg wpm-locator">
            <div class="wpm-product-locator">
                <div class="map-page">
                    <div class="wrapper">
                        <section class="wpm-prod-sec">
                            <div class="wpm-cont-fluid">
                                <div class="wpm-row">
                                    <div class="col-12">
                                        <div class="stores-map">
                                            <div class="wpm-row no-gutters row">
                                                <div class="col-xl-4 col-lg-5 col-md-6" id="storeList">
                                                <div class="wpm-locator-left">
                                                <!-- SEARCH WRAPPER -->
                                                <div class="wpm-storelist-cont">
                                                    <div class="wpm-sidebr-top">
                                                        <div class="wpm-title">
                                                            <div class="wpm-box stores-count">
                                                                <h3><em>${branches.length}</em>
                                                                    <span>Cửa hàng</span>
                                                                </h3>
                                                                <span
                                                                    class="hide prods-count"><em>0</em></span>
                                                            </div>
                                                        </div>
                                                        <div class="store-search">
                                                            <span class="wpm-input-group">
                                                                <i style="position: absolute;top: 10px;left: 10px;"
                                                                    class="fas fa-lg fa-store fas fa-lg fa-store"></i>
                                                                <input id="wpm-store-name" type="text"
                                                                    class="wpm-control ap-input w-100"
                                                                    placeholder="Tìm kiếm cửa hàng"
                                                                    autocomplete="off" spellcheck="false"
                                                                    role="combobox" aria-autocomplete="both"
                                                                    aria-expanded="false"
                                                                    aria-owns="algolia-autocomplete-listbox-0"
                                                                    dir="auto" style="">
                                                                <pre aria-hidden="true"
                                                                    style="position: absolute; visibility: hidden; white-space: pre; font-family: Roboto, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: normal; text-indent: 0px; text-rendering: auto; text-transform: none;"></pre>
                                                                <span class="algolia-autocomplete"
                                                                    style="position: absolute; z-index: 100; display: none; direction: ltr;"><span
                                                                        class="ap-dropdown-menu"
                                                                        role="listbox"
                                                                        id="algolia-autocomplete-listbox-0"
                                                                        style="display: block; left: 0px; right: auto;">
                                                                        <div class="ap-dataset-1"></div>
                                                                    </span></span><button type="button"
                                                                    aria-label="clear"
                                                                    class="ap-input-icon ap-icon-clear"
                                                                    style="display: none;"><svg width="12"
                                                                        height="12" viewBox="0 0 12 12"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M.566 1.698L0 1.13 1.132 0l.565.566L6 4.868 10.302.566 10.868 0 12 1.132l-.566.565L7.132 6l4.302 4.3.566.568L10.868 12l-.565-.566L6 7.132l-4.3 4.302L1.13 12 0 10.868l.566-.565L4.868 6 .566 1.698z">
                                                                        </path>
                                                                    </svg></button>
                                                            </span>
                                                            <div class="input-group-append">
                                                                <div class="wpm-status-swtch">
                                                                    <input type="checkbox" name="onoffswitch"
                                                                        class="onoffswitch-checkbox"
                                                                        id="wpm-t-switch">
                                                                    <label for="wpm-t-switch">
                                                                        <span
                                                                            class="status-txt un-actv">Mở cửa</span>
                                                                        <span
                                                                            class="status-txt actv">Tất cả</span>
                                                                        <div class="toggle">
                                                                            <div class="minitoggle">
                                                                                <div class="toggle-handle">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="wpm-store-items">

                                                    </div><!-- ITEM WRAPPER -->
                                                </div>
                                            </div>
                                                </div>
                                                <div class="col-xl-8 col-lg-7 col-md-6 ">
                                                    <div class="map-holder">
                                                        <div class="wpm-map-wrapper">
                                                            <div id="wpm-map-canvas" style="height: 500px"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
            `);
            renderStoreList(branches);
        };
        const renderStoreList = (branches) => {
            $('.stores-count h3 em').html(branches.length)
            let storeListHtml = "";
            branches.forEach((branch) => {
                storeListHtml += ` <li class="wpm-store-li"
                data-id="${branch.id}">
                <div class="store-item"
                    data-index="0">
                    <div class="info-heading-left">
                        <div class="wpm-img-hldr">
                            <img class="thumbnail"
                                src="${branch.image?.path_with_original_size}"
                                alt="logo">
                        </div>
                        <div class="wpm-box">
                            <h3>${branch.name}</h3>
                            <p>${branch.address?.full_address}</p>
                        </div>
                    </div>
                    <div class="stores-info-contant">
                        <ul class="addr-sec">
                            <li><a
                                    href="tel:${branch.phone}">
                                    <span
                                        class="wpm-addr-sec-icon"><i
                                            class="fas fa-lg fa-phone-volume"></i></span>${branch.phone}</a>
                            </li>
                            <li><a class="wpm-loc-mail"
                                    href="mailto:${branch.email}"><span
                                        class="wpm-addr-sec-icon"><i
                                            class="fas fa-lg fa-mail-bulk"></i></span>${branch.email}</a>
                            </li>
                            <li>
                                <a class="wpm-info-days-hrs">
                                    <span class="wpm-addr-sec-icon">
                                    <i class="fas fa-lg fa-clock"></i></span>${branch.open_time} - ${branch.close_time}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div
                        class="stores-info-btn wpm-cta-cont">
                        <a class="wpm-btn wpm-btn-outline wpm-lnk-direction"
                            data-id="${branch.id}"><i
                                class="fas fa-lg fa-directions"></i>
                            <span>Đi đến</span></a>
                    </div>
                </div>
            </li>`;
            });
            $(".wpm-store-items").html(`
            <div class="item-content wpm-storelocator-panel"
            id="wpm-pl-panel">
            <ul class="wpm-store-list">
            ${storeListHtml}
            </ul>
            <ul class="wpm-store-list hide"
                id="wpm-pl-highlight">
            </ul>
        </div>
            `);
        };
        initStoreMapData();
    }
}
