$(document).ready(function() {
    // Función para iniciar la cuenta regresiva
    function startCountdown(endDate) {
        // ... (tu código de cuenta regresiva original)
    }

    // Configurar fecha de finalización de la cuenta regresiva
    let endDate = new Date("June 30, 2024 15:00:00").getTime();
    startCountdown(endDate);

    // Manejo del envío del formulario principal
    $("#solicitudForm").submit(function(event) {
        event.preventDefault();

        // Obtener todos los datos del formulario
        var formData = $(this).serialize();

        // Obtener los datos de las acciones de contención
        var accionesData = [];
        $("#reporteTable tbody tr").each(function() {
            var accion = $(this).find("input[name='accion_contencion[]']").val();
            var fecha = $(this).find("input[name='accion_fecha[]']").val();
            var responsable = $(this).find("input[name='accion_responsable[]']").val();
            if (accion && fecha && responsable) {
                accionesData.push({ accion: accion, fecha: fecha, responsable: responsable });
            }
        });

        // Obtener los datos del plan
        var planData = [];
        $("#planTable tbody tr").each(function() {
            var accion = $(this).find("input[name='plan_accion[]']").val();
            var fecha = $(this).find("input[name='plan_fecha[]']").val();
            var responsable = $(this).find("input[name='plan_responsable[]']").val();
            var evidencia = $(this).find("input[name='plan_evidencias[]']").val();
            if (accion && fecha && responsable && evidencia) {
                planData.push({ accion: accion, fecha: fecha, responsable: responsable, evidencia: evidencia });
            }
        });

        // Combinar todos los datos
        var allData = {
            formData: formData,
            accionesData: accionesData,
            planData: planData
        };

        // Enviar todos los datos a guardar_reporte.php
        $.ajax({
            url: "guardar_reporte.php",
            method: "POST",
            data: allData,
            success: function(response) {
                alert(response); // Mostrar la respuesta del servidor (éxito o error)
                // Puedes redirigir o actualizar la página aquí si es necesario
            }
        });
    });

    // Guardar acción individual
    $("#reporteTable, #planTable").on("click", ".guardar-btn", function() {
        var tableId = $(this).data("table-id");
        var fila = $(this).closest("tr");
        var id = fila.find("td:first").text(); // Obtener el ID si existe

        // Obtener los datos de la fila según la tabla
        var data = {};
        if (tableId === "reporteTable") {
            data.accion_contencion = fila.find("textarea[name='accion_contencion[]']").val();
            data.fecha = fila.find("input[name='accion_fecha[]']").val();
            data.responsable = fila.find("input[name='accion_responsable[]']").val();
        } else if (tableId === "planTable") {
            data.accion = fila.find("input[name='plan_accion[]']").val();
            data.fecha = fila.find("input[name='plan_fecha[]']").val();
            data.responsable = fila.find("input[name='plan_responsable[]']").val();
            data.evidencia = fila.find("input[name='plan_evidencias[]']").val();
        }

        // Enviar los datos a través de AJAX
        $.ajax({
            url: (tableId === "reporteTable") ? "guardar_accion.php" : "guardar_plan.php",
            method: "POST",
            data: { id: id, ...data }, // Combina el ID con los datos de la fila
            success: function(response) {
                if (response.includes("éxito")) {
                    alert("Acción guardada con éxito.");
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
