@extends('layouts.dashboard')

@section('content')

<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>
            
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Presences</h3>
                <p class="text-subtitle text-muted">Handle employee presence</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Presence</li>
                        <li class="breadcrumb-item active" aria-current="page">New</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Create.
                </h5>
            </div>
            <div class="card-body">

                @if (session('role') == 'Belajar Laravel')
                
                <form action="{{ route('presences.store') }}" method="POST">
                    @csrf 

                    <div class="mb-3">
                        <label for="" class="form-label">Employee</label>
                        <select name="employee_id" id="status" class="form-control">
                            @foreach($employees as $employee)
                                 <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                            @endforeach  
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Check In</label>
                        <input type="text" class="form-control datetime" name="check_in" required>
                        @error('check_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Check Out</label>
                        <input type="text" class="form-control datetime" name="check_out" required>
                        @error('check_out')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Date</label>
                        <input type="text" class="form-control date" name="date" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="leave">Leave</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('presences.index') }}" class="btn btn-secondary">Back to List</a>
                </form> 

                @else

                <form action="{{ route('presences.store') }}" method="POST">
                    @csrf

                    <div class="mb-3"><b>Note</b> : Mohon izinkan akses lokasi, supaya presensi diterima</div>

                    <div class="mb-3">
                        <label for="" class="form-label">Latitude</label>
                        <input type="text" class="form-control" name="latitude" id="latitude" required>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Longitude</label>
                        <input type="text" class="form-control" name="longitude" id="longitude" required>
                    </div>

                    <div class="mb-3">
                        <iframe width="500" height="300" frameborder="0" scrollinge="no" marginheight="0" marginwidth="0" src=""></iframe>
                    </div>

                    <button type="submit" class="btn btn-primary" id="btn-present" disabled>Present</button>
                </form>

                @endif
            </div>
        </div>

    </section>
</div>

<script>
const iframe = document.querySelector('iframe');
const officeLat = -6.8911104;
const officeLon = 107.544576;
const threshold = 0.01; 


if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        const currentLat = position.coords.latitude;
        const currentLon = position.coords.longitude;

        // Update input field
        const latInput = document.getElementById('latitude');
        const lonInput = document.getElementById('longitude');
        
        if(latInput && lonInput) {
            latInput.value = currentLat;
            lonInput.value = currentLon;
        }

        // Update Iframe Map - Menggunakan format URL yang benar
        if(iframe) {
            iframe.src = `https://maps.google.com/maps?q=${currentLat},${currentLon}&z=15&output=embed`;
        }

        // Hitung jarak (Pythagoras sederhana)
        const distance = Math.sqrt(Math.pow(currentLat - officeLat, 2) + Math.pow(currentLon - officeLon, 2));

        const btnPresent = document.getElementById('btn-present');
        if (distance <= threshold) {
            alert('Kamu berada di kantor, selamat bekerja!');
            if(btnPresent) btnPresent.removeAttribute('disabled');
        } else {
            alert('Kamu tidak berada di kantor. Pastikan kamu berada di area kantor untuk absen.');
        }
    }, function(error) {
        alert("Gagal mengambil lokasi: " + error.message);
    });
} else {
    alert("Browser kamu nggak support lokasi nih.");
}
</script>

@endsection 