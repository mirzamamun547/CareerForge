function initLocationAutocomplete(config) {
    const searchInput = document.querySelector(config.searchInput);
    const suggestionsContainer = document.querySelector(config.suggestionsContainer);
    const latInput = document.querySelector(config.latInput);
    const lonInput = document.querySelector(config.lonInput);
    const cityInput = document.querySelector(config.cityInput);
    const countryInput = document.querySelector(config.countryInput);
    const selectedCard = document.querySelector(config.selectedCard);

    let debounceTimeout = null;

    if (!searchInput || !suggestionsContainer) return;

    // Create container styling dynamically if not present
    if (!document.getElementById('autocomplete-styles')) {
        const style = document.createElement('style');
        style.id = 'autocomplete-styles';
        style.innerHTML = `
            .autocomplete-suggestions {
                position: absolute;
                z-index: 1050;
                background: white;
                border: 1px solid #E5E7EB;
                border-radius: 0.5rem;
                width: 100%;
                max-height: 250px;
                overflow-y: auto;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }
            .autocomplete-suggestion {
                padding: 0.75rem 1rem;
                cursor: pointer;
                border-bottom: 1px solid #F3F4F6;
                transition: background 0.15s;
                font-size: 0.875rem;
                color: #374151;
            }
            .autocomplete-suggestion:hover {
                background: #F3F4F6;
            }
            .autocomplete-suggestion:last-child {
                border-bottom: none;
            }
            .selected-location-card {
                background: #F9FAFB;
                border: 1px solid #E5E7EB;
                border-radius: 0.75rem;
                padding: 1rem;
                margin-top: 0.75rem;
                font-size: 0.85rem;
            }
        `;
        document.head.appendChild(style);
    }

    // Wrap the input's parent in relative position to anchor absolute suggestions container
    const wrapper = searchInput.parentElement;
    if (wrapper) {
        wrapper.style.position = 'relative';
    }

    function showCard(locationName, city, country, lat, lon) {
        if (!selectedCard) return;
        selectedCard.innerHTML = `
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <div class="flex-grow-1">
                    <div class="fw-bold text-dark mb-1">Selected Location</div>
                    <div class="text-secondary mb-2">${locationName}</div>
                    <div class="row g-2 text-secondary" style="font-size: 0.78rem;">
                        <div class="col-6"><strong>City:</strong> ${city || 'N/A'}</div>
                        <div class="col-6"><strong>Country:</strong> ${country || 'N/A'}</div>
                        <div class="col-6"><strong>Lat:</strong> ${parseFloat(lat).toFixed(5)}</div>
                        <div class="col-6"><strong>Lon:</strong> ${parseFloat(lon).toFixed(5)}</div>
                    </div>
                </div>
            </div>
        `;
        selectedCard.style.display = 'block';
    }

    function hideCard() {
        if (!selectedCard) return;
        selectedCard.innerHTML = '';
        selectedCard.style.display = 'none';
    }

    // Pre-populate card if values are already filled (e.g. during Edit Job)
    if (searchInput.value && latInput && latInput.value && lonInput && lonInput.value) {
        showCard(searchInput.value, cityInput ? cityInput.value : '', countryInput ? countryInput.value : '', latInput.value, lonInput.value);
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimeout);
        const query = searchInput.value.trim();

        if (query.length < 3) {
            suggestionsContainer.innerHTML = '';
            // If they cleared the search field, reset the hidden inputs and card
            if (query.length === 0) {
                if (latInput) latInput.value = '';
                if (lonInput) lonInput.value = '';
                if (cityInput) cityInput.value = '';
                if (countryInput) countryInput.value = '';
                hideCard();
                // Dispatch input event for preview
                searchInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
            return;
        }

        debounceTimeout = setTimeout(() => {
            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&addressdetails=1&limit=8&countrycodes=bd`)
                .then(response => response.json())
                .then(data => {
                    suggestionsContainer.innerHTML = '';
                    if (data && data.length > 0) {
                        const list = document.createElement('div');
                        list.className = 'autocomplete-suggestions';
                        
                        data.forEach(item => {
                            const suggestion = document.createElement('div');
                            suggestion.className = 'autocomplete-suggestion';
                            suggestion.innerHTML = `📍 ${item.display_name}`;
                            
                            suggestion.addEventListener('click', () => {
                                const displayName = item.display_name;
                                const lat = item.lat;
                                const lon = item.lon;

                                // Parse city & country
                                const addr = item.address || {};
                                const city = addr.city || addr.town || addr.village || addr.suburb || addr.municipality || '';
                                const country = addr.country || '';

                                // Set values
                                searchInput.value = displayName;
                                if (latInput) latInput.value = lat;
                                if (lonInput) lonInput.value = lon;
                                if (cityInput) cityInput.value = city;
                                if (countryInput) countryInput.value = country;

                                showCard(displayName, city, country, lat, lon);

                                suggestionsContainer.innerHTML = '';

                                // Trigger preview change handlers
                                searchInput.dispatchEvent(new Event('input', { bubbles: true }));
                                searchInput.dispatchEvent(new Event('change', { bubbles: true }));

                                if (typeof config.onSelect === 'function') {
                                    config.onSelect(item);
                                }
                            });
                            
                            list.appendChild(suggestion);
                        });
                        suggestionsContainer.appendChild(list);
                    } else {
                        suggestionsContainer.innerHTML = '<div class="autocomplete-suggestions"><div class="autocomplete-suggestion text-muted p-3">No suggestions found</div></div>';
                    }
                })
                .catch(err => {
                    console.error('Error fetching suggestions:', err);
                });
        }, 300);
    });

    // Close suggestions on clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
            suggestionsContainer.innerHTML = '';
        }
    });
}
