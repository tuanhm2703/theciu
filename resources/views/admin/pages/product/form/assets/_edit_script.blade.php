<script>
    const loadInventoryOfProduct = () => {
        $.ajax({
            url: `{{ route('admin.ajax.product.inventories', $product->id) }}`,
            type: 'GET',
            success: (res) => {
                attributes = res.data
                renderAttributeTable()
                renderAttributeForm(false)
            }
        })
    }
    $(document).ready(() => {
        loadInventoryOfProduct()
    })
</script>
