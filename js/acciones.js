$(document).ready(function() {
    // Guardar datos al hacer clic en el botón "Guardar"
    $("#reporteTable").on("click", ".guardar-btn", function() {
        var fila = $(this).closest("tr");
        // ... (resto del código para obtener los datos de la fila)

        $.ajax({
            url: "guardar_accion.php",
            method: "POST",
            data: { id: id, accion_contencion: accion_contencion, fecha: fecha, responsable: responsable },
            success: function(response) {
                if (response.includes("éxito")) { // Verificar si la respuesta contiene "éxito"
                    alert("Acción guardada con éxito."); // Mostrar mensaje de éxito específico
                    // Puedes actualizar el ID de la fila si es una inserción nueva
                    if (!id) {
                        fila.find("td:first").text(response.split(":")[1]); // Obtener el nuevo ID de la respuesta
                    }
                } else {
                    alert(response); // Mostrar el mensaje de error si no fue exitoso
                }
            }
        });
    });
});
