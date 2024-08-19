function verificarArchivo(id) {
  fetch(`../img/productos/${id}`, { method: 'HEAD' })
    .then(response => {
      if (response.ok) {
        console.log('El archivo existe.');
      } else {
        console.log('El archivo no existe.');
      }
    })
    .catch(error => {
      console.error('Error al verificar el archivo:', error);
     
    });
}
function mostrarColores(id) {
  let selectTalla = document.getElementById("talla");
    let idT = selectTalla.value;
  
    // alert(`alor Slelet:${idT},"Valor ID",${id}`);
    let url = "proceso/editarCantidadItem.php";
    let formData = new FormData();
    formData.append("action", "color");
    formData.append("id", id);
    formData.append("idT", idT);
  
    fetch(url, {
      method: "POST",
      body: formData,
      mode: "cors",
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.ok) {
          let divColor = document.getElementById('color');
          divColor.innerHTML = ""; // Limpia el contenido del div

          let htmlContent = ""; // Variable para acumular el HTML
          data.res.forEach(element => {
              let colorRGB = `rgb(${element.r}, ${element.g}, ${element.b})`;
              // htmlContent += `<span class="circle" style="background-color: ${colorRGB};"></span>`;
              htmlContent += ` <button type="button" class="btn circle" style="background-color: ${colorRGB};"></button>`;
          });
          divColor.innerHTML = htmlContent; // Asigna el HTML generado al div        
        }
      }); 
}

function mostrarResultados(resultados) {
    const productoHtml = document.getElementById('conte-productos');
    productoHtml.innerHTML = ''; 

    resultados.forEach(element => {  
        let id = element.id;
        let nombre = element.nombre;
        let categoria = element.categoria;
        let precio = parseFloat(element.precio).toFixed(2); // Formatear precio

        productoHtml.innerHTML += `
            <div class="col">
                <div class="card">
                    <img src='img/productos/${id}.jpeg' class="d-block w-100" style="height:18rem;" id="img-cart"> 
                    <div class="card-body">
                        <h4 class="card-title">${nombre}</h4>
                        <h5 class="card-title">${categoria}</h5>
                        <p class="card-text">${precio}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="detalle.php?id=${id}" class="btn btn-outline-info">Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
            
    });
    verificarArchivo(id);

}
function FiltroPorCategoria(){
  
}
document.addEventListener("DOMContentLoaded", function () {
  let inputBusqueda = document.getElementById("Search");
  inputBusqueda.addEventListener("keyup", function (event) {
    let url = "proceso/filtro.php"; // URL al endpoint PHP
    let formData = new FormData();
    formData.append("valor", event.target.value);

    fetch(url, {
      method: "POST",
      body: formData,
      mode: "cors",
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.ok) {
            mostrarResultados(data.resul);
        } else {
          console.error(
            "No se encontraron resultados o hubo un error en la solicitud."
          );
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
      });
  });
});


let eliminarItem = document.getElementById("eliminarModal");
eliminarItem.addEventListener("show.bs.modal", function (event) {
  let button = event.relatedTarget;
  let id = button.getAttribute("data-bs-id");
  let buttonEliminar = eliminarModal.querySelector(
    ".modal-footer #btn-eliminar"
  );
  buttonEliminar.value = id;
});

function EliminarItem() {
  let bontonEliminar = document.getElementById("btn-eliminar");
  let id = bontonEliminar.value;

  let url = "proceso/editarCantidadItem.php";
  let formData = new FormData();
  formData.append("action", "eliminar");
  formData.append("id", id);

  fetch(url, {
    method: "POST",
    body: formData,
    mode: "cors",
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.ok) {
        location.reload();
      }
    });
}

function addItemProducto(id) {
  let url = "proceso/carrito.php";
  let formData = new FormData();
  formData.append("id", id);
  // formData.append("token", token);

  fetch(url, {
    method: "POST",
    body: formData,
    mode: "cors",
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.ok) {
        let elemento = document.getElementById("num_cart");
        elemento.innerHTML = data.numero;
      }
    });
}
function editarCantidadItem(cantidad, id) {
  let url = "proceso/editarCantidadItem.php";
  let formData = new FormData();
  formData.append("action", "agregar");
  formData.append("id", id);
  formData.append("cantidad", cantidad);

  fetch(url, {
    method: "POST",
    body: formData,
    mode: "cors",
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.ok) {
        let divSubtotal = document.getElementById("subtotal_" + id);
        divSubtotal.innerHTML = data.sub;

        let total = 0.0;
        let lista = document.getElementsByName("subtotal[]");

        for (let i = 0; i < lista.length; i++) {
          total += parseFloat(lista[i].innerHTML.replace(/[$,]/g, ""));
          console.log(total);
        }

        total = new Intl.NumberFormat("en-US", {
          minimumFractionDigits: 2,
        }).format(total);
        document.getElementById("total").innerHTML = "$" + total;
      }
    });
}
function openModalMensaje() {
  let mensaje = document.getElementById("myModal");
  mensaje.style.display = "block";
}
function closeModal() {
  var modal = document.getElementById("myModal");
  modal.style.display = "none";
}
function registrarPago() {
  let ncuenta = document.getElementById("ncuenta").value;
  let url = "proceso/pago.php";
  let formData = new FormData();
  formData.append("ncuenta", ncuenta);

  fetch(url, {
    method: "POST",
    body: formData,
    mode: "cors",
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.ok) {
        location.reload();
      } else {
        openModalMensaje();
      }
    });
}
