<script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "{{ $product->name }}",
      "image": "{{ $product->detail_link }}",
      "description": "$product->short_description",
      "sku": "$product->sku",
      "brand": {
        "@type": "Brand",
        "name": "{{ getAppName() }}"
      },
      "offers": {
        "@type": "Offer",
        "url": "{{ $product->detail_link }}",
        "priceCurrency": "VND",
        "price": "$product->sale_price",
        "availability": "https://schema.org/InStock",
        "seller": {
          "@type": "Organization",
          "name": "{{ getAppName() }}"
        }
      }
    }
    </script>
