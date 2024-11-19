/***********************USUARIOS *******************************/

// Inicialización de la tabla de usuarios con DataTable
var tableUsuarios;

document.addEventListener("DOMContentLoaded", function () {
  // Configuración de DataTable para listar usuarios
  tableUsuarios = $("#tableUsuarios").DataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: "./models/usuarios/table_usuarios.php",
      dataSrc: "",
    },
    columns: [
      { data: "nombres" },
      { data: "apellidos" },
      { data: "dni" },
      { data: "fechaNac" },
      { data: "email" },
      { data: "direccion" },
      { data: "celular" },
      { data: "descripcionArea" },
      { data: "descripcionCargo" },
      { data: "nombreUsuario" },
      { data: "descripcionRol" },
      { data: "status" },
      { data: "options" },
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "asc"]],
  });

  // Evento para crear o actualizar usuario en el formulario
  var formUser = document.querySelector("#formUser");
  if (formUser) {
    formUser.onsubmit = function (e) {
      e.preventDefault();

      // Verificar si es una actualización o una creación
      const idUsuario = document.querySelector("#idUsuario").value;
      const url = idUsuario ? "./models/usuarios/editar-usuario.php" : "./models/usuarios/ajax-usuarios.php";
      const successMessage = idUsuario ? "Usuario Actualizado" : "Usuario Creado";

      // Validación de campos obligatorios
      var strNombres = document.querySelector("#txtNombres").value;
      var strApellidos = document.querySelector("#txtApellidos").value;
      var strDNI = document.querySelector("#txtDNI").value;
      var strEmail = document.querySelector("#txtEmail").value;
      var strCelular = document.querySelector("#txtCelular").value;
      var strArea = document.querySelector("#listArea").value;
      var strCargo = document.querySelector("#listCargo").value;
      var strUsuario = document.querySelector("#txtUsuario").value;
      var strRol = document.querySelector("#listRol").value;
      var intStatus = document.querySelector("#listStatus").value;

      if (
        strNombres === "" ||
        strApellidos === "" ||
        strDNI === "" ||
        strEmail === "" ||
        strCelular === "" ||
        strArea === "" ||
        strCargo === "" ||
        strUsuario === "" ||
        strRol === "" ||
        intStatus === ""
      ) {
        swal("Atención", "Todos los campos son necesarios", "error");
        return false;
      }

      // Envío de datos con fetch
      var formData = new FormData(formUser);
      fetch(url, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status) {
            $("#modalFormUser").modal("hide");
            formUser.reset();
            swal(successMessage, data.msg, "success");
            tableUsuarios.ajax.reload(); // Recargar tabla tras actualización o creación
          } else {
            swal("Atención", data.msg, "error");
          }
        })
        .catch((error) => console.error("Error en la solicitud:", error));
    };
  } else {
    console.error("El formulario #formUser no se encontró en el DOM.");
  }
});

// Función para abrir el modal y crear un nuevo usuario
function openModal() {
  const idUsuarioField = document.querySelector("#idUsuario");
  if (idUsuarioField) idUsuarioField.value = "";

  const titleModal = document.querySelector("#titleModal");
  if (titleModal) titleModal.innerHTML = "Nuevo Usuario";

  const modalHeader = document.querySelector(".modal-header");
  if (modalHeader)
    modalHeader.classList.replace("updateRegister", "headerRegister");

  const btnActionForm = document.querySelector("#btnActionForm");
  if (btnActionForm) btnActionForm.classList.replace("btn-info", "btn-primary");

  const btnText = document.querySelector("#btnText");
  if (btnText) btnText.innerHTML = "Guardar";

  const formUser = document.querySelector("#formUser");
  if (formUser) formUser.reset();

  $("#modalFormUser").modal("show");
}

// Evento de edición de usuario
$("#tableUsuarios").on("click", ".btnEditUser", function () {
  const idUsuario = $(this).data("id");

  // Solicitud para obtener los datos del usuario a editar
  fetch(`./models/usuarios/obtener-usuario.php?id=${idUsuario}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.status) {
        document.querySelector("#titleModal").innerHTML = "Actualizar Usuario";
        document
          .querySelector(".modal-header")
          .classList.replace("headerRegister", "updateRegister");
        document
          .querySelector("#btnActionForm")
          .classList.replace("btn-primary", "btn-info");
        document.querySelector("#btnText").innerHTML = "Actualizar";

        // Cargar datos en el formulario
        document.querySelector("#idUsuario").value = data.data.idUsuario;
        document.querySelector("#idPersonal").value = data.data.idPersonal;
        document.querySelector("#txtNombres").value = data.data.nombres;
        document.querySelector("#txtApellidos").value = data.data.apellidos;
        document.querySelector("#txtDNI").value = data.data.dni;
        document.querySelector("#txtFechaNac").value = data.data.fechaNac;
        document.querySelector("#txtEmail").value = data.data.email;
        document.querySelector("#txtDireccion").value = data.data.direccion;
        document.querySelector("#txtCelular").value = data.data.celular;
        document.querySelector("#listArea").value = data.data.idArea;
        document.querySelector("#listCargo").value = data.data.idCargo;
        document.querySelector("#txtUsuario").value = data.data.nombreUsuario;
        document.querySelector("#listStatus").value = data.data.status;
        document.querySelector("#listRol").value = data.data.idRol;

        $("#modalFormUser").modal("show");
      } else {
        Swal.fire("Error", data.msg, "error");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      Swal.fire("Error", "Hubo un problema al obtener los datos del usuario.", "error");
    });
});

// Función para eliminar un usuario con SweetAlert2
$("#tableUsuarios").on("click", ".deleteUser", function () {
  const idUsuario = $(this).data("id");

  Swal.fire({
    title: "Eliminar Usuario",
    text: "¿Realmente desea eliminar el usuario?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Eliminar",
    cancelButtonText: "Cancelar",
    dangerMode: true,
  }).then((result) => {
    if (result.isConfirmed) {
      fetch("./models/usuarios/eliminar-usuario.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `idUsuario=${idUsuario}`,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status) {
            Swal.fire("Usuario Eliminado", data.msg, "success");
            tableUsuarios.ajax.reload(); // Recargar la tabla tras eliminar
          } else {
            Swal.fire("Atención", data.msg, "error");
          }
        })
        .catch((error) => {
          console.error("Error en la solicitud:", error);
          Swal.fire(
            "Error",
            "Hubo un problema al eliminar el usuario.",
            "error"
          );
        });
    }
  });
});

/*********************** FIN USUARIOS *******************************/
