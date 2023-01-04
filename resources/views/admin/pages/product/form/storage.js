const renderAttributeColumn = (inventory) => {
    let output = ''
    inventory.values.forEach((value, index) => {
        output += `<td>
                        <p class="text-center text-md" style="font-size: 0.875rem">${value.value ? value.value : ''}</p>
                        ${index == 0 ? `<x-admin.bordered-add-btn text=" "style="width: 50px; height: 50px; margin: auto">
                                                    <svg viewBox="0 0 23 21" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M18.5 0A1.5 1.5 0 0 1 20 1.5V12c-.49-.07-1.01-.07-1.5 0V1.5H2v12.65l3.395-3.408a.75.75 0 0 1 .958-.087l.104.087L7.89 12.18l3.687-5.21a.75.75 0 0 1 .96-.086l.103.087 3.391 3.405c.81.813.433 2.28-.398 3.07A5.235 5.235 0 0 0 14.053 18H2a1.5 1.5 0 0 1-1.5-1.5v-15A1.5 1.5 0 0 1 2 0h16.5z">
                                                                                                                                                                                                </path>
                                                                                                                                                                                                <path
                                                                                                                                                                                                    d="M6.5 4.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zM18.5 14.25a.75.75 0 0 1 1.5 0v2.25h2.25a.75.75 0 0 1 0 1.5H20v2.25a.75.75 0 0 1-1.5 0V18h-2.25a.75.75 0 0 1 0-1.5h2.25v-2.25z">
                                                                                                                                                                                                </path>
                                                                                                                                                                                            </svg>
                                                                                                                                                </x-admin.bordered-add-btn>` : ''}
                    </td>`
    })
    return output
}
renderAttributeTableHeader()
inventories.forEach(inventory => {
    $('#attribute-table tbody').append(`<tr>
                                            ${renderAttributeColumn(inventory)}
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text border-end">₫</span>
                                                    <input type="number" class="form-control" placeholder="Nhập vào">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" value="0">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Nhập vào">
                                                </div>
                                            </td>
                                        </tr>`)
})
