<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

</head>


<body>

    <!-- modal para editar cliente -->
    <div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title">Editar</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
        <form id="form-cliente-edit" type="POST" href="clientes/update">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre-edit" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email-edit" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono-edit" name="telefono" class="form-control" required pattern="[0-9]+">
            </div>
            <div class="text-center">
            <button type="submit" class="btn btn-primary mt-2">Guardar</button>
            </div>
        </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        </div>

        </div>
    </div>
    </div>

    <div class="container">

        <!-- crear cliente -->
        <div id="form-section" class="card p-4 bg-light mt-4">
            <h2>Crear cliente</h2>
            <form id="form-cliente" type="POST" href="clientes/store">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" class="form-control" required pattern="[0-9]+">
                </div>
                <div class="text-center">
                <button type="submit" class="btn btn-primary mt-2">Guardar</button>
                </div>
            </form>
        </div>

        <!-- lista de clientes -->
        <div id="clientes-section" class="mt-5">
            <h2>Lista de clientes</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="clientes-list">


                </tbody>
            </table>
        </div>

        <!-- API de pokemon -->
        <div id="pokemon-section" class="card p-4 bg-light mt-4">
            <h2>API de pokemon</h2>
            <button id="btn-pokemon" class="btn btn-info">Consultar pokemon</button>
            <div id="pokemon-result" class="mt-3"></div>
        </div>
    </div>

    <script>

    $(document).ready(function() {
    //listar clientes
    function listarClientes() {
        $.ajax({
            url: '/clientes/show',
            method: 'GET',
            success: function(clientes) {
                console.log(clientes);
                let html = '';
                clientes.forEach(function(cliente) {
                    html += `
                        <tr>
                            <td>${cliente.nombre}</td>
                            <td>${cliente.email}</td>
                            <td>${cliente.telefono}</td>
                            <td>
                                <button type="button" class="btn btn-dark btn-edit" data-bs-toggle="modal" data-bs-target="#myModal"
                                    data-id="${cliente.id}">
                                    Editar
                                </button>
                                <button class="btn btn-danger btn-delete" data-id="${cliente.id}">Eliminar</button>
                            </td>
                        </tr>`;
                });
                $('#clientes-list').html(html);
            },
            error: function() {
                console.log('Error al listar los clientes');
            }
        });
    }

    //crear un cliente
    $('#form-cliente').on('submit', function(e) {
        e.preventDefault();
        const clienteData = {
            "_token": "{{csrf_token()}}",
            nombre: $('#nombre').val(),
            email: $('#email').val(),
            telefono: $('#telefono').val(),
        };

        $.ajax({
            url: '/clientes/store',
            method: 'POST',
            data: clienteData,
            success: function(response) {
                alert('Cliente creado con éxito');
                listarClientes();
                $('#form-cliente')[0].reset();
            },
            error: function(response) {
                console.log('Error al crear el cliente');
            }
        });
    });

    //actualizar un cliente
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');

        $.ajax({
            url: `/clientes/update`,
            method: 'POST',
            data: {"_token": "{{csrf_token()}}",id: id},
            success: function(cliente) {
                $('#nombre-edit').val(cliente.nombre);
                $('#email-edit').val(cliente.email);
                $('#telefono-edit').val(cliente.telefono);
                $('#form-cliente-edit').data('id', cliente.id);

                $('#myModal').modal('show');
            },
            error: function() {
                console.log('Error al obtener los datos del cliente');
            }
        });
    });

    //guardar los cambios de un cliente
    $('#form-cliente-edit').on('submit', function(e) {
        e.preventDefault();
        const id = $(this).data('id');

        const clienteData = {
            "_token": "{{csrf_token()}}",
            nombre: $('#nombre').val(),
            email: $('#email').val(),
            telefono: $('#telefono').val(),
        };

        if (id) {
            $.ajax({
                url: `/clientes/update`,
                method: 'POST',
                data: clienteData,
                success: function() {
                    alert('Cliente actualizado con éxito');
                    listarClientes();
                    $('#form-cliente-edit')[0].reset();
                    $('#form-cliente-edit button').text('Guardar'); // Cambia el texto de nuevo a Guardar
                    $('#form-cliente-edit').removeData('id'); // Elimina el ID almacenado
                },
                error: function() {
                    console.log('Error al actualizar el cliente');
                }
            });
        }
    });

    //eliminar un cliente
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');

        if (confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
            $.ajax({
                url: `/clientes/eliminar`,
                method: 'POST',
                data: {"_token": "{{csrf_token()}}",id: id},
                success: function() {
                    alert('Cliente eliminado con éxito');
                    listarClientes();
                },
                error: function() {
                    console.log('Error al eliminar el cliente');
                }
            });
        }
    });

    //consultar pokemon
    $('#btn-pokemon').on('click', function() {
        $.ajax({
            url: '/api/pokemon',
            method: 'GET',
            success: function(pokemon) {
                $('#pokemon-result').html(`
                    <p>JSON: ${pokemon}</p>
                `);
                console.log(pokemon);
            },
            error: function() {
                console.log('Error al consumir la API de Pokémon');
            }
        });
    });

    //inicializar la lista de clientes
    listarClientes();
});

    </script>
</body>
</html>
