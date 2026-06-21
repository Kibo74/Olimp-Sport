    </main>
    <footer>
        <div>Autor: <strong>Borna Babić</strong></div>
        <div>Kontakt: <a href="mailto:bbabic@tvz.hr">bbabic@tvz.hr</a></div>
        <div class="copyright">&copy; <?php echo date('Y'); ?> Olimp Sport &middot; Programiranje web aplikacija</div>
    </footer>

</div>
<script>
    var lastY = window.scrollY;
    const header = document.querySelector("header");

    window.addEventListener("scroll", () => {
        const currentY = window.scrollY;

        if (currentY > lastY && currentY > 80) {
            header.classList.add("is-hidden");
        } else {
            header.classList.remove("is-hidden");
        }

        lastY = currentY;
    });
</script>
</body>
</html>
