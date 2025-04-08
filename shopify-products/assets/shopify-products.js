window.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("products-placeholder");
    if (!container) return;

    fetch(sp_data.api_url + '?_embed') // Needed for featured image
        .then(response => response.json())
        .then(products => {
            container.innerHTML = '';
            if (products.length === 0) {
                container.innerHTML = '<p>No products found.</p>';
                return;
            }

            products.forEach(product => {
                const title = product.title.rendered;
                const content = product.content.rendered;
                const meta = product.meta || {};
                const price = meta.price || 'N/A';

                // Featured image
                let image = '';
                if (
                    product._embedded &&
                    product._embedded['wp:featuredmedia'] &&
                    product._embedded['wp:featuredmedia'][0].source_url
                ) {
                    image = product._embedded['wp:featuredmedia'][0].source_url;
                }

                const card = document.createElement('div');
                card.className = 'product-card';
                card.innerHTML = `
                    ${image ? `<img src="${image}" alt="${title}" class="product-image" />` : ''}
                    <h3 class="product-title">${title}</h3>
                    <p class="product-price">₹${price}</p>
                    <div class="product-desc">${content}</div>
                `;
                container.appendChild(card);
            });
        })
        .catch(error => {
            console.error("Fetch error:", error);
            container.innerHTML = `<p>Error loading products: ${error.message}</p>`;
        });
});
