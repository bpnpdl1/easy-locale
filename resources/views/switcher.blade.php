<div class="language-switcher" style="padding:20px;background:white;border-radius:8px;margin-bottom:20px;">
    @foreach (config('easy-locale.locales') as $code => $name)
        <a href="{{ url('lang/' . $code) }}" class="lang-btn {{ app()->getLocale() === $code ? 'active' : '' }}"
            style="margin:0 10px;padding:8px 16px;text-decoration:none;color:#333;
                  border:1px solid #ddd;border-radius:4px;display:inline-block;">
            {{ $name }}
        </a>
    @endforeach
</div>

<style>
    .lang-btn:hover {
        background: #e5e7eb;
    }

    .lang-btn.active {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
</style>
