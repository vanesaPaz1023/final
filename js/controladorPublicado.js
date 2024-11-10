function agregarPublicado() {
    const producto = document.getElementById("producto").value;
    const talla = document.getElementById("talla").value;
    const color = document.getElementById("color").value;
    const unidad = document.getElementById("unidad").value;

    // Verifica si los campos obligatorios tienen un valor válido
    if (producto === "0" || talla === "0" || color === "0") {
        alert("Por favor, selecciona un producto, talla y color válidos.");
        return;
    }

    const url = "../../proceso/gestionPublicado.php"; // Cambia esta ruta si es necesario
    const formData = new FormData();
    formData.append("action", "agregar");
    formData.append("producto", producto);
    formData.append("talla", talla);
    formData.append("color", color);
    formData.append("unidad", unidad);

    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors",
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then((data) => {
        if (data.ok) {
            // Limpiar los campos del formulario
            document.getElementById("crearPublicadoForm").reset();
            alert("Se publico con éxito");
            window.location.href = '../../form/Producto/gestionPublicado.php';
        } else {
            alert("Error al agregar la publicacion");
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        alert("Hubo un problema al publicar el producto.");
    });
}
function editarPublicado() {
    const producto = document.getElementById("producto").value;
    const id = document.getElementById("id").value;
    const talla = document.getElementById("talla").value;
    const color = document.getElementById("color").value;
    const unidad = document.getElementById("unidad").value;

    // Verifica si los campos obligatorios tienen un valor válido
    if (producto === "0" || talla === "0" || color === "0") {
        alert("Por favor, selecciona un producto, talla y color válidos.");
        return;
    }

    const url = "../../proceso/gestionPublicado.php"; // Cambia esta ruta si es necesario
    const formData = new FormData();
    formData.append("action", "editar");
    formData.append("id", id);
    formData.append("producto", producto);
    formData.append("talla", talla);
    formData.append("color", color);
    formData.append("unidad", unidad);

    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors",
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then((data) => {
        if (data.ok) {
            // Limpiar los campos del formulario
            document.getElementById("editarPublicadoForm").reset();
            alert("Se edito con éxito");
            window.location.href = '../../form/Producto/gestionPublicado.php';
        } else {
            alert("Error al editar la publicacion");
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        alert("Hubo un problema al editar la publicacion.");
    });
}

