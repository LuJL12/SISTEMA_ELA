<!-- Importar SweetAlert2 desde CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Tu archivo functions-usuarios.js -->
<script src="path/to/your/functions-usuarios.js"></script>

<!-- Vertically centered scrollable modal usuarios -->
<div class="modal fade" id="modalFormUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
                    <form id="formUser" name="formUser" method="POST">
                        <input type="hidden" name="idUsuario" id="idUsuario" value="">

                        <div class="form-group">
                            <label class="control-label">Nombres</label>
                            <input class="form-control" id="txtNombres" name="txtNombres" type="text" placeholder="Nombre del usuario" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Apellidos</label>
                            <input type="text" class="form-control" id="txtApellidos" name="txtApellidos" placeholder="Apellidos" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">DNI</label>
                            <input type="text" class="form-control" id="txtDNI" name="txtDNI" placeholder="DNI">
                        </div>
                        <div class="form-group">
                            <label for="control-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="txtFechaNac" name="txtFechaNac" required>
                        </div>
                        <div class="form-group">
                            <label for="control-label">Email</label>
                            <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="control-label">Dirección</label>
                            <textarea class="form-control" rows="4" id="txtDireccion" name="txtDireccion" placeholder="Dirección"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="control-label">Celular</label>
                            <input type="text" class="form-control" id="txtCelular" name="txtCelular" placeholder="Celular" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Área</label>
                            <select class="form-control" name="listArea" id="listArea" required>
                                <option value="1">Secretaria</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Cargo</label>
                            <select class="form-control" name="listCargo" id="listCargo" required>
                                <option value="1">Practicante</option>
                                <option value="2">Técnico Administrativo</option>
                                <option value="3">Oficinista</option>
                                <option value="4">CIST</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="control-label">Usuario</label>
                            <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="Usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="control-label" class="form-label">Contraseña</label>
                            <input type="password" class="form-control validPass" id="clave" name="clave" placeholder="Contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Rol</label>
                            <select class="form-control" name="listRol" id="listRol" required>
                                <option value="1">Administrador</option>
                                <option value="2">Usuario</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Status</label>
                            <select class="form-control" name="listStatus" id="listStatus" required>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                        <div class="tile-footer">
                            <button id="btnActionForm" class="btn btn-primary" type="submit">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i>
                                <span id="btnText">Guardar</span>
                            </button>&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-secondary" data-dismiss="modal">
                                <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="modalFormUser" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUser" name="formUser">
                <div class="modal-body">
                    <input type="hidden" id="idUsuario" name="idUsuario">
                    <input type="hidden" id="idPersonal" name="idPersonal">

                    <div class="form-group">
                        <label for="txtNombres">Nombres</label>
                        <input type="text" class="form-control" id="txtNombres" name="txtNombres" required>
                    </div>
                    <div class="form-group">
                        <label for="txtApellidos">Apellidos</label>
                        <input type="text" class="form-control" id="txtApellidos" name="txtApellidos" required>
                    </div>
                    <div class="form-group">
                        <label for="txtDNI">DNI</label>
                        <input type="text" class="form-control" id="txtDNI" name="txtDNI" required>
                    </div>
                    <div class="form-group">
                        <label for="txtFechaNac">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="txtFechaNac" name="txtFechaNac" required>
                    </div>
                    <div class="form-group">
                        <label for="txtEmail">Email</label>
                        <input type="email" class="form-control" id="txtEmail" name="txtEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="txtDireccion">Dirección</label>
                        <textarea class="form-control" id="txtDireccion" name="txtDireccion" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="txtCelular">Celular</label>
                        <input type="text" class="form-control" id="txtCelular" name="txtCelular" required>
                    </div>
                    <div class="form-group">
                        <label for="listArea">Área</label>
                        <select class="form-control" id="listArea" name="listArea" required>
                            <!-- Opciones de área se cargarán dinámicamente -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="listCargo">Cargo</label>
                        <select class="form-control" id="listCargo" name="listCargo" required>
                            <!-- Opciones de cargo se cargarán dinámicamente -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="txtUsuario">Usuario</label>
                        <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" required>
                    </div>
                    <div class="form-group">
                        <label for="listRol">Rol</label>
                        <select class="form-control" id="listRol" name="listRol" required>
                            <!-- Opciones de rol se cargarán dinámicamente -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="listStatus">Estado</label>
                        <select class="form-control" id="listStatus" name="listStatus" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnActionForm" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>