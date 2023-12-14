// document.addEventListener("DOMContentLoaded", function () {
//     const form = document.getElementById("predict-form");
//     const loadingIndicator = document.getElementById("loading-indicator");

    // form.addEventListener("submit", function (event) {
    //     event.preventDefault();
    //
    //     // Show the loading indicator
    //     loadingIndicator.style.display = "block";
    //
    //     const formData = new FormData(form);
    //
    //     // Send data to server using AJAX
    //     fetch("ai-calculation.php", {
    //         method: "POST",
    //         body: formData
    //     })
    //         .then(response => response.json())
    //         .then(data => {
    //             // Handle the response from the server
    //             loadingIndicator.style.display = "none";
    //
    //             console.log(data);
    //             if (data.success) {
    //                 // Update the UI with the result
    //                 const resultContainer = document.getElementById("result-container");
    //                 resultContainer.innerText = `Price: ${data.price} USD`;
    //             } else {
    //                 alert(data.message);
    //             }
    //         })
    //         .catch(error => {
    //             console.error("Error:", error);
    //
    //             // Hide the loading indicator in case of an error
    //             loadingIndicator.style.display = "none";
    //         });
    // });

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("predict-form");
        const loadingIndicator = document.getElementById("loading-indicator");
        const submitbutton = document.getElementById("submit-button")

        document.getElementById("predict-form").addEventListener("submit", function (event) {
            // Das Standardformularverhalten verhindern
            event.preventDefault();

            // Zeige den Ladebalken an
            loadingIndicator.style.display = "block";

            const formData = new FormData(form);

            // Send data to server using AJAX
            fetch("ai-calculation.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the response from the server
                    console.log(data);
                    if (data.success) {
                        // Update the UI with the result
                        setTimeout(function () {
                            showResultContainer(data.price);
                        }, 4000);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while processing the request.");
                });
        });

        function showResultContainer(price) {
            // Verstecke den Ladebalken
            loadingIndicator.style.display = "none";

            var resultContainer = document.getElementById("result-container");
            var priceResult = document.getElementById("price-result");

            // Setzen Sie den Text des Ergebnisses
            priceResult.textContent = "Price: " + price + " USD";

            // Container anzeigen
            resultContainer.style.display = "block";
        }
    });

