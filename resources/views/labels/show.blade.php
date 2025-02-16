<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $label->name }}</title>
     <!-- Favicon -->
     <link rel="icon" href="/images/LogoPNG.png" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/label_details.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

 
  <!-- Optionally include Bootstrap 5 for consistency (local asset) -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

  <!-- Materialize CSS (CDN) -->
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
    integrity="sha512-5Mu4X0UL+H7OHM8xKLb7kPP8OH6kGdrAaNFeCz4nywsSBgj3vlpJbIFpJOVHTD9K1PLcIISViU6Ly6q4zsdZzQ==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer"
/>


</head>
<body>

    <div class="app-bar">

        <!-- Back icon (chevron_left) -->
    <span class="material-symbols-outlined back-icon" onclick="window.history.back();">
        chevron_left
      </span>

        <h1 class="app-bar-title">{{ $label->name }}</h1>

        <!-- "more_horiz" icon -->
    <span class="material-symbols-outlined dropdown-trigger" id="dropdown-trigger">
        more_horiz
      </span>
      
        <ul id="label-dropdown" class="dropdown-content">
            <li><a href="{{ route('labels.edit', $label->id) }}"><span class="material-symbols-outlined">edit</span>Edit Label</a></li>
            <li>
                <form action="{{ route('labels.destroy', $label->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"><span class="material-symbols-outlined">delete</span>Delete Label</button>
                </form>
            </li>
        </ul>
    </div>


    <div class="container">
        <img src="{{ asset('images/illustration1.png') }}" alt="Label Illustration" class="label-illustration">
        <div class="label-details">
            <h2>{{ $label->name }}</h2>
            <p><strong>Description:</strong> {{ $label->description }}</p>
            <p><strong>Color:</strong> <span class="label-color" style="background-color: {{ $label->color }};"></span> {{ $label->color }}</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownTrigger = document.querySelector('#dropdown-trigger');
            const dropdownMenu = document.querySelector('#label-dropdown');

            // Toggle dropdown menu visibility
            dropdownTrigger.addEventListener('click', function() {
                dropdownMenu.classList.toggle('open');
            });

            // Close dropdown menu if clicked outside
            document.addEventListener('click', function(event) {
                if (!dropdownTrigger.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('open');
                }
            });
        });
    </script>
</body>
</html>
