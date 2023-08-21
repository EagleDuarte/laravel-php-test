$(document).ready(function() {
    // Função para carregar a lista de produtos via AJAX
    function carregarProdutos() {
        $.get('/produtos', function(data) {
            $('#produto-table tbody').empty();

            data.forEach(function(produto) {
                $('#produto-table tbody').append(
                    `<tr>
                        <td>${produto.id}</td>
                        <td>${produto.nome}</td>
                        <td>${produto.descricao}</td>
                        <td>${produto.preco}</td>
                        <td>${produto.quantidade}</td>
                        <td>
                            <button class="excluir" data-id="${produto.id}" data-token="{{ csrf_token() }}">Excluir</button>
                        </td>
                    </tr>`
                );
            });
        });
    }

    // Carrega a lista de produtos ao carregar a página
    carregarProdutos();

    // Função para confirmar a exclusão de um produto
    $(document).on('click', '.excluir', function() {
        var id = $(this).data('id');
        if (confirm('Tem certeza que deseja excluir este produto?')) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            console.log('Exclusão iniciada para o ID:', id);
    
            $.ajax({
                url: '/produtos/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Inclui o token CSRF no cabeçalho
                },
                success: function() {
                    console.log('Produto excluído com sucesso:', id);
                    carregarProdutos(); // Carrega a lista atualizada após a exclusão
                },
                error: function(xhr, status, error) {
                    console.log('Erro ao excluir produto:', error);
                }
            });
        }
    });
});