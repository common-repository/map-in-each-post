document.addEventListener('DOMContentLoaded', function () {
    var enablePointsCheckbox = document.getElementById('_enable_mapineachpost_points');
    var pointsContainer = document.getElementById('points-container');
    var addPointButton = document.getElementById('add-point');

    if (enablePointsCheckbox) {
        enablePointsCheckbox.addEventListener('change', function () {
            var isChecked = this.checked;
            pointsContainer.style.display = isChecked ? '' : 'none';
            addPointButton.style.display = isChecked ? '' : 'none';
        });

        document.getElementById('add-point').addEventListener('click', function () {
            var container = document.getElementById('points-container');
            var index = container.querySelectorAll('.point-table').length;
            var html = `
            <table class="point-table">
                <thead>
                    <tr>
                        <th colspan="2">` + mapInEachPostLabels.point + ` ` + (index + 1) + `</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label for="points[` + index + `][title]">` + mapInEachPostLabels.title + `:</label></td>
                        <td><input type="text" name="points[` + index + `][title]" value="" /></td>
                    </tr>
                    <tr>
                        <td><label for="points[` + index + `][desc]">` + mapInEachPostLabels.description + `:</label></td>
                        <td><input type="text" name="points[` + index + `][desc]" value="" /></td>
                    </tr>
                    <tr>
                        <td><label for="points[` + index + `][lat]">` + mapInEachPostLabels.latitude + `:</label></td>
                        <td><input type="text" name="points[` + index + `][lat]" value="" /></td>
                    </tr>
                    <tr>
                        <td><label for="points[` + index + `][lon]">` + mapInEachPostLabels.longitude + `:</label></td>
                        <td><input type="text" name="points[` + index + `][lon]" value="" /></td>
                    </tr>
                    <tr>
                        <td><label for="points[` + index + `][link]">` + mapInEachPostLabels.link + `:</label></td>
                        <td><input type="text" name="points[` + index + `][link]" value="" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="button" class="remove-point">` + mapInEachPostLabels.removePoint + `</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
            `;
            container.insertAdjacentHTML('beforeend', html);
            attachRemoveEvents();
        });
    }

    function attachRemoveEvents() {
        var buttons = document.getElementsByClassName('remove-point');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].removeEventListener('click', removeEvent);
            buttons[i].addEventListener('click', removeEvent);
        }
    }

    function removeEvent(e) {
        e.target.closest('table').remove();
    }

    attachRemoveEvents();
});
