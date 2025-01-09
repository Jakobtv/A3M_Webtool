function updateOptions(type) {
    if (type == 'standort') {
        var selectedValue = document.getElementById("standort").value;
        if (selectedValue) {
            $.ajax({
                url: "../update-options.php",
                type: "POST",
                data: {
                    type: type,
                    selectedStandort: selectedValue
                },
                success: function(response) {
                    console.log(response.data);
                    var options = response.data;
                    var companySelect = document.getElementById("firmen");
                    companySelect.innerHTML = '<option value="">Bitte wählen</option>';
                    options.forEach(function(option) {
                        var opt = document.createElement("option");
                        opt.value = option.value;
                        opt.text = option.value;
                        companySelect.appendChild(opt);
                    })
                }

            })
        }
    } else if (type == 'firmen') {
        var selectedStandort = document.getElementById("standort").value;
        var selectedFirmen = document.getElementById("firmen").value;
        if (selectedStandort) {
            $.ajax({
                url: "../update-options.php",
                type: "POST",
                data: {
                    type: type,
                    selectedStandort: selectedStandort,
                    selectedFirmen: selectedFirmen
                },
                success: function(response) {
                    console.log(response.data);
                    var options = response.data;
                    var departmentSelect = document.getElementById("abteilungen");
                    departmentSelect.innerHTML = '<option value="">Bitte wählen</option>'
                    options.forEach(function(option) {
                        var opt = document.createElement("option");
                        opt.value = option.value;
                        opt.text = option.value;
                        departmentSelect.appendChild(opt);
                    })
                }

            })
        }
    }
}