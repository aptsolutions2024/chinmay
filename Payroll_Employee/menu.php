<!-- Hamburger Menu HTML -->
<div class="menu">
    <div class="hamburger" onclick="toggleMenu()">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
    <div class="menucontent" id="menuLinks">
        <a href="/employee-home">Home</a>
        <a href="/payment-slip">Payment Slip</a>
        <a href="/attendance">Attendance</a>
        <a href="/advance">Advance</a>
    </div>
</div>

<!-- CSS for Hamburger Menu -->
<style>
    body {
        font-family: "Arial", sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .menu {
        height: 60px;
        background-color: #008b8b; /* Green shade similar to the header */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        position: relative;
    }

    .menucontent {
        display: flex;
        gap: 30px;
    }

    .menucontent a {
        color: white;
        text-decoration: none;
        font-size: 16px;
    font-weight: normal;
        padding: 10px 20px;
        transition: background-color 0.3s;
    }

    .menucontent a:hover {
        background-color: #285d68;
        border-radius: 5px;
    }

    /* Hamburger icon */
    .hamburger {
        display: none;
        flex-direction: column;
        cursor: pointer;
        position: absolute;
        /*left: 20px; */
        /* Adjust this to align it as needed */
    }

    .hamburger .bar {
        width: 25px;
        height: 3px;
        background-color: white;
        margin: 4px 0;
        transition: 0.3s;
    }

    /* Responsive for smaller screens */
    @media screen and (max-width: 768px) {
        .menucontent {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 60px;
            left: 0;
            background-color: #2f6f7e;
            width: 100%;
            z-index: 1;
        }

        .menucontent a {
            padding: 15px;
            text-align: center;
            width: 100%;
            font-size: 16px;
        }

        .hamburger {
            display: flex;
        }

        .menu {
            justify-content: space-between;
        }
    }

    /* Toggle class for opening the menu */
    .menucontent.show {
        display: flex;
    }
</style>

<!-- JavaScript for Menu Toggle -->
<script>
    function toggleMenu() {
        const menuLinks = document.getElementById('menuLinks');
        menuLinks.classList.toggle('show');
    }
</script>
