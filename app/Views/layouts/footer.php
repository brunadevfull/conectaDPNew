 
 </main>
    
    <footer class="bg-gray-800 text-white py-4 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?>©PAPEM  - Todos os direitos reservados</p>
        </div>
    </footer>
    
    <!-- Page-specific scripts -->
    <?php if (isset($pageScripts)): ?>
        <?php foreach($pageScripts as $script): ?>
            <script src="<?= $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>