function agregarProducto() {
    const nombre = document.getElementById("nombre").value;
    const descripcion = document.getElementById("descripcion").value;
    const unidad = document.getElementById("unidad").value;
    const precio = document.getElementById("precio").value;
    const categoria = document.getElementById("categoria").value;
    const imagen = document.getElementById("imagen").files[0]; 

    // Verifica si la categoría es válida
    if (categoria === "0") {
        alert("Por favor, selecciona una categoría.");
        return;
    }

    const url = "../../proceso/gestionProducto.php"; // Cambia esta ruta si es necesario
    const formData = new FormData();
    if (imagen) {
        formData.append("imagen", imagen); // Solo añade la imagen si ha sido seleccionada
    }
    formData.append("action", "agregar");
    formData.append("nombre", nombre);
    formData.append("descripcion", descripcion);
    formData.append("unidad", unidad);
    formData.append("precio", precio);
    formData.append("categoria", categoria);

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
            document.getElementById("productoForm").reset();
            alert("Producto agregado con éxito");
            window.location.href = '../../form/Producto/gestionProducto.php';
        } else {
            alert(data.mensaje || "Error al agregar el producto."); // Mostrar mensaje del servidor si existe
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        alert("Hubo un problema al agregar el producto.");
    });
}
function editarProducto() {
    const id = document.getElementById("id").value;
    const nombre = document.getElementById("nombre").value.trim();
    const descripcion = document.getElementById("descripcion").value.trim();
    const unidad = document.getElementById("unidad").value.trim();
    const precio = document.getElementById("precio").value.trim();
    const categoria = document.getElementById("categoria").value;
    const estado = document.getElementById("estado").value;
    const imagen = document.getElementById("imagen").files[0]; 

    // Validación de campos vacíos
    if (!nombre || !descripcion || !unidad || !precio || categoria === "0") {
        alert("Por favor, completa todos los campos obligatorios y selecciona una categoría.");
        return;
    }

    const url = "../../proceso/gestionProducto.php"; // Cambia esta ruta si es necesario
    const formData = new FormData();
    if (imagen) {
        formData.append("imagen", imagen); // Solo añade la imagen si ha sido seleccionada
    }
    formData.append("action", "editar");
    formData.append("id", id);
    formData.append("nombre", nombre);
    formData.append("descripcion", descripcion);
    formData.append("unidad", unidad);
    formData.append("precio", precio);
    formData.append("categoria", categoria);
    formData.append("estado", estado);

    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors",
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.ok) {
            // Limpiar los campos del formulario
            document.getElementById("editarProductoForm").reset();
            alert("Producto editado con éxito");
            window.location.href = '../../form/Producto/gestionProducto.php';
        } else {
            alert(data.mensaje || "Error al editar el producto."); // Mostrar mensaje del servidor si existe
        }
    })
    .catch((error) => {
        alert("Hubo un problema al editar el producto.");
    });
}

