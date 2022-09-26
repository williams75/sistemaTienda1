   </div>
   </div>
   <script>
       const base_url = "<?= base_url(); ?>";
       const smony = "<?= SMONEY; ?>";
   </script>

   <script type="text/javascript" src="<?= media(); ?>/js/jquery-3.5.1.min.js"></script>

   <!-- Js template JS-->
   <script src="<?= media(); ?>/js/bootstrap/bootstrap.js"></script>
   <script src="<?= media(); ?>/js/bootstrap/datatables-simple-demo.js"></script>
   <script src="<?= media(); ?>/js/bootstrap/bootstrap.bundle.min.js"></script>

   <!-- Page specific javascripts-->
   <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
   <script type="text/javascript" src="<?= media(); ?>/js/tinymce/tinymce.min.js"></script>

   <!-- Data table plugin-->
   <script type="text/javascript" src="<?= media(); ?>/js/plugins/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="<?= media(); ?>/js/plugins/dataTables.bootstrap.min.js"></script>
   <!-- Form  -->
   <script type="text/javascript" src="<?= media(); ?>/js/plugins/bootstrap-select.min.js"></script>

   <script type="text/javascript" language="javascript" src="<?= media(); ?>/js/plugins/1.5.2-dataTables.buttons.min.js"></script>
   <script type="text/javascript" language="javascript" src="<?= media(); ?>/js/plugins/3.1.3-jszip.min.js"></script>
   <script type="text/javascript" language="javascript" src="<?= media(); ?>/js/plugins/0.1.36-pdfmake.min.js"></script>
   <script type="text/javascript" language="javascript" src="<?= media(); ?>/js/plugins/0.1.36-vfs_fonts.js"></script>

   <script type="text/javascript" language="javascript" src="<?= media(); ?>/js/plugins/1.5.2-buttons.html5.min.js"></script>
   <!--FIN Data table plugin-->
   <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
   </body>

   </html>