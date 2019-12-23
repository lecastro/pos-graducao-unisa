<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    @php
        //FB Pixel "views"
    @endphp
    fbq('init', '1261944523925570');
    fbq('track', 'PageView');
    @hasSection('script.facebook-pixel')
        @php
            //Chamar essa section('script.facebook-pixel') quando houver a necessidade de um FB Pixel Customizado. Ex. fbq('track', 'CompleteRegistration');
        @endphp
        @yield('script.facebook-pixel')
    @endif
</script>
<noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1261944523925570&ev=PageView&noscript=1"
/></noscript>
