<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger d-inline-flex align-items-center px-4 py-2 rounded text-capitalize fw-semibold fs-6']) }}>
    {{ $slot }}
</button>