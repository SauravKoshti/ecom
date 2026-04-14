<script>
(function () {
    const body      = document.getElementById('optionsBody');
    const typeSelect = document.getElementById('typeSelect');
    const colorHeader = document.getElementById('colorHeader');

    function rowIndex() {
        return body.querySelectorAll('tr').length;
    }

    function toggleColor() {
        const isColor = typeSelect.value === 'color';
        colorHeader.style.display = isColor ? '' : 'none';
        body.querySelectorAll('.color-col').forEach(td => {
            td.style.display = isColor ? '' : 'none';
        });
    }

    typeSelect.addEventListener('change', toggleColor);
    toggleColor();

    document.getElementById('addOption').addEventListener('click', function () {
        const i = rowIndex();
        const isColor = typeSelect.value === 'color';
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input type="text" name="options[${i}][value]"
                       class="form-control form-control-sm" placeholder="Option value">
            </td>
            <td class="color-col" style="${isColor ? '' : 'display:none'}">
                <input type="color" name="options[${i}][color_hex]"
                       class="form-control form-control-sm form-control-color" value="#000000">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger remove-option">
                    <i class="bi bi-x"></i>
                </button>
            </td>`;
        body.appendChild(tr);
        tr.querySelector('.remove-option').addEventListener('click', () => tr.remove());
    });

    body.querySelectorAll('.remove-option').forEach(btn => {
        btn.addEventListener('click', () => btn.closest('tr').remove());
    });

    // Re-index all option rows before submit so names are sequential
    body.closest('form').addEventListener('submit', function () {
        body.querySelectorAll('tr').forEach((tr, i) => {
            tr.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/options\[\d+\]/, `options[${i}]`);
            });
        });
    });
})();
</script>
