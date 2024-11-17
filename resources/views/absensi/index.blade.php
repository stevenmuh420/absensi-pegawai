<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Pegawai</title>
    <style>
        #camera, #canvas { display: block; margin: 10px auto; }
    </style>
</head>
<body>

<h2>Absensi Pegawai</h2>

<form id="absensiForm">
    <label for="nama">Nama Pegawai:</label>
    <input type="text" id="nama" name="nama" required><br><br>

    <video id="camera" width="320" height="240" autoplay></video><br><br>
    <button type="button" id="takePhoto">Ambil Foto</button><br><br>

    <canvas id="canvas" width="320" height="240" style="display:none;"></canvas><br><br>
    <input type="hidden" name="foto" id="foto">
    <button type="submit">Kirim Absensi</button>
</form>

<script>
    let video = document.getElementById('camera');
    let canvas = document.getElementById('canvas');
    let context = canvas.getContext('2d');
    let takePhotoButton = document.getElementById('takePhoto');
    let absensiForm = document.getElementById('absensiForm');
    let fotoInput = document.getElementById('foto');

    // Mengakses kamera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            video.srcObject = stream;
        })
        .catch(function(error) {
            console.log("Tidak dapat mengakses kamera", error);
        });

    // Fungsi untuk mengambil foto
    takePhotoButton.addEventListener('click', function() {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        let fotoData = canvas.toDataURL('image/jpeg');
        fotoInput.value = fotoData;  // Menyimpan gambar ke input hidden
    });

    // Mengirim form absensi
    absensiForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(absensiForm);

        fetch('/absensi', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            absensiForm.reset();
            canvas.style.display = 'none';  // Sembunyikan canvas setelah kirim
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

</body>
</html>
