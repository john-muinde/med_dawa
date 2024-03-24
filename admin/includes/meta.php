<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
<!-- IonIcons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/css/adminlte.min.css">
<!-- CUSTOM stylesheet -->
<link rel="stylesheet" href="assets/css/styles.css">


<script src="./assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="./assets/js/adminlte.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>


<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>

<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>


<!-- Datatables css-->
<style>
    .list-group-item {
        background-color: #494e53 !important;
    }

    .nav-item.active {
        background-color: #494e53 !important;
        border-radius: 5px;
    }

    .nav-pills .nav-link:not(.active):hover {
        background-color: #494e53 !important;
        border-radius: 5px;
        color: white !important;
    }
</style>

<script>
    let timeout;

    function showPopup() {
        $("#sessionExtendModal").modal("show");
    }

    function hidePopup() {
        $("#sessionExtendModal").modal("hide");
    }

    function logout() {
        var baseURL = window.location.origin;
        window.location.href = baseURL + "/includes/logout_inc.php";
    }

    function startSessionTimeout() {
        timeout = setTimeout(() => {
            showPopup();
            setTimeout(() => {
                logout();
            }, 30000);
        }, 300000);
    }

    // document.addEventListener("mousemove", () => {
    //     clearTimeout(timeout);
    //     startSessionTimeout();
    // });

    // $("#extendSessionBtn").click(() => {
    //     hidePopup();
    //     startSessionTimeout();
    // });

    // $("#logoutBtn").click(() => {
    //     logout();
    // });

    // startSessionTimeout();

    // $("#logoutBtn").click(() => {
    //     logout();
    // });

    // startSessionTimeout();
</script>