<?php

class ControladorEmpresas
{
    /*=============================================
    MOSTRAR EMPRESAS
    =============================================*/
    static public function ctrMostrarEmpresas($valor)
    {
        $item = null;
        $tabla = "empresas";
        $respuesta = ModeloEmpresas::mdlMostrarEmpresas($item, $valor, $tabla);
        return $respuesta;
    }

    /*=============================================
    REGISTRO DE EMPRESAS
    =============================================*/
    static public function ctrCrearEmpresa()
    {
        if (isset($_POST["registrarEmpresa"])) { // Validamos el botón

            if (
                isset($_POST["nit"]) &&
                isset($_POST["nombre"]) &&
                isset($_POST["direccion"]) &&
                isset($_POST["area"]) &&
                isset($_POST["coevaluador"]) &&
                isset($_POST["contacto"]) &&
                isset($_POST["email"]) &&
                isset($_POST["departamento"]) &&
                isset($_POST["ciudad"]) &&
                isset($_POST["estado"])
            ) {
                if (
                    preg_match('/^[0-9]+$/', $_POST["nit"]) &&
                    preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9.,-]+$/', $_POST["nombre"]) &&
                    preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9.,#-]+$/', $_POST["direccion"]) &&
                    preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9.,-]+$/', $_POST["area"]) &&
                    preg_match('/^[0-9]+$/', $_POST["coevaluador"]) && // coevaluador es ID numérico
                    preg_match('/^[0-9]+$/', $_POST["contacto"]) &&
                    preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST["email"]) &&
                    preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["departamento"]) &&
                    preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["ciudad"]) &&
                    preg_match('/^(Activo|Inactivo)$/', $_POST["estado"])
                ) {
                    $tabla = "empresas";
                    $datos = array(
                        "nit" => $_POST["nit"],
                        "nombre" => $_POST["nombre"],
                        "direccion" => $_POST["direccion"],
                        "area" => $_POST["area"],
                        "id_usuarios" => $_POST["coevaluador"], // ✅ CORRECTO para el registro
                        "contacto" => $_POST["contacto"],
                        "email" => $_POST["email"],
                        "departamento" => $_POST["departamento"],
                        "ciudad" => $_POST["ciudad"],
                        "estado" => $_POST["estado"]
                    );

                    $respuesta = ModeloEmpresas::mdlRegistrarEmpresa($tabla, $datos);

                    if ($respuesta == "ok") {
                        echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "La empresa ha sido guardada correctamente",
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if(result.isConfirmed){
                                window.location = "empresas";
                            }
                        });
                        </script>';
                    } else {
                        echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Error al guardar la empresa",
                            confirmButtonText: "Cerrar"
                        });
                        </script>';
                    }
                } else {
                    echo '<script>
                    Swal.fire({
                        icon: "warning",
                        title: "Datos inválidos en el formulario",
                        confirmButtonText: "Cerrar"
                    });
                    </script>';
                }
            }
        }
    }

   /*=============================================
EDITAR EMPRESA
=============================================*/
static public function ctrEditarEmpresa()
{
    if (isset($_POST["editarEmpresa"])) {

        if (
            isset($_POST["idempresa"]) && // ← Asegurarse de que venga el ID
            isset($_POST["editNit"]) &&
            isset($_POST["editNombre"]) &&
            isset($_POST["editDireccion"]) &&
            isset($_POST["editArea"]) &&
            isset($_POST["editCoevaluador"]) &&
            isset($_POST["editContacto"]) &&
            isset($_POST["editEmail"]) &&
            isset($_POST["editDepartamento"]) &&
            isset($_POST["editCiudad"]) &&
            isset($_POST["editEstado"])
        ) {

            if (
                preg_match('/^[0-9]+$/', $_POST["idempresa"]) &&
                preg_match('/^[0-9]+$/', $_POST["editNit"]) &&
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9.,-]+$/', $_POST["editNombre"]) &&
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9.,#-]+$/', $_POST["editDireccion"]) &&
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9.,-]+$/', $_POST["editArea"]) &&
                preg_match('/^[0-9]+$/', $_POST["editCoevaluador"]) &&
                preg_match('/^[0-9]+$/', $_POST["editContacto"]) &&
                preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST["editEmail"]) &&
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editDepartamento"]) &&
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editCiudad"]) &&
                preg_match('/^(Activo|Inactivo)$/', $_POST["editEstado"])
            ) {

                $datos = array(
                    "id_empresas" => $_POST["idempresa"], // ← NUEVO: usar id_empresas para identificar
                    "nit"         => $_POST["editNit"],
                    "nombre"      => $_POST["editNombre"],
                    "direccion"   => $_POST["editDireccion"],
                    "area"        => $_POST["editArea"],
                    "id_usuarios" => $_POST["editCoevaluador"],
                    "contacto"    => $_POST["editContacto"],
                    "email"       => $_POST["editEmail"],
                    "departamento"=> $_POST["editDepartamento"],
                    "ciudad"      => $_POST["editCiudad"],
                    "estado"      => $_POST["editEstado"]
                );

                $tabla = "empresas";
                $respuesta = ModeloEmpresas::mdlEditarEmpresa($tabla, $datos);

                if ($respuesta == "ok") {
                    echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "La empresa ha sido editada correctamente",
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if(result.isConfirmed){
                            $("#actualizarModal").modal("hide");
                            // Opcional: recarga AJAX
                        }
                    });
                    </script>';
                } else {
                    echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error al actualizar la empresa",
                        confirmButtonText: "Cerrar"
                    });
                    </script>';
                }

            } else {
                echo '<script>
                Swal.fire({
                    icon: "warning",
                    title: "Datos inválidos en el formulario",
                    confirmButtonText: "Cerrar"
                });
                </script>';
            }
        }
    }
}

    /*=============================================
    CAMBIAR ESTADO EMPRESA
    =============================================*/
    static public function ctrCambiarEstadoEmpresa($nit, $estado)
    {
        return ModeloEmpresas::mdlCambiarEstadoEmpresa($nit, $estado);
    }
}