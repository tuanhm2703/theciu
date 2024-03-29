<style>
    .nav-item svg {
        width: 50px;
    }

    .promotion-setting-header {
        padding: 1rem;
        border: 1px solid #e5e5e5;
        background: #f6f6f6;
        border-radius: 4px;
    }

    .product-name {
        display: inline-block;
        white-space: nowrap;
        overflow: hidden !important;
        text-overflow: ellipsis;
        position: relative;
        top: 5px;
    }

    .remove-product-btn {
        width: 30px;
        height: 30px;
        border: 1px solid lightgrey;
        border-radius: 50%;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: grey;
        cursor: pointer;
        transition: all 0.1s ease-in;
    }

    .promotion-setting-wrapper {
        margin-right: calc(-0.5 * 1.5rem);
        margin-left: calc(-0.5 * 1.5rem);
    }

    .remove-product-btn:hover {
        border-color: grey;
    }

    .product-header-info {
        padding: 1rem 0;
        background-color: #fafafa;
    }

    .product-header-info img {
        margin-left: 1rem
    }

    .product-setting-info {
        padding: 1rem 0;
        padding-top: 0;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        overflow: hidden;
    }

    .promotion-setting-header label {
        line-height: 1rem;
    }

    .text-sm {
        font-size: 0.75rem !important;
    }

    [name=discountType] {
        border-radius: 0;
        border: 0;
        padding: 0 3px;
    }
    [name=discountType]:focus {
        background: transparent;
        border-right: none !important;
        box-shadow: none !important;
    }
</style>
