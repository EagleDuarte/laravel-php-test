$(document).ready(function() {
    function renderizarTabelaProdutos(data) {
        var tabela = $('#produto-table tbody');
        tabela.empty();

        data.forEach(function(produto) {
            tabela.append(`
                <tr>
                    <td>${produto.id}</td>
                    <td>${produto.nome}</td>
                    <td>${produto.descricao}</td>
                    <td>${produto.preco}</td>
                    <td>${produto.quantidade}</td>
                    <td>
                        <button class="excluir" data-id="${produto.id}">Excluir</button>
                    </td>
                </tr>`
            );
        });
    }

    function carregarProdutos() {
        $.get('/produtos', function(data) {
            renderizarTabelaProdutos(data);
        });
    }

    carregarProdutos();

    $(document).on('click', '.excluir', function() {
        var id = $(this).data('id');
        if (confirm('Tem certeza que deseja excluir este produto?')) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            console.log('Exclusão iniciada para o ID:', id);

            var deleteUrl = '/produtos/' + id;
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function() {
                    console.log('Produto excluído com sucesso:', id);
                    carregarProdutos();
                },
                error: function(xhr, status, error) {
                    console.log('Erro ao excluir produto:', error);
                    console.log('Status:', status);
                    console.log('Response:', xhr.responseText);
                }
            });
        }
    });
});