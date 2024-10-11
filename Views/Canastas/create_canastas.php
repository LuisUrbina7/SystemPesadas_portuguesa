<?php headerAdmin($data);?>

<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3"> Crear Canasta. </h6>

                </div>
            </div> 


                                    <div class="card-body">
                                        <form role="form" id="" class="text-start">
                                        <div class="input-group input-group-outline my-3 is-filled">
                                            <label class="form-label">Codigo</label>
                                            <input type="text" class="form-control" id="codigo_canasta" name="codigo_canasta" placeholder="..." value="<?= $data['page_data']['COORELATIVO'] ?>" readonly>
                                        </div> 

                                        <div class="input-group input-group-outline mb-3 ">
                                            <label class="form-label">Descripcion</label>
                                            <input type="text" id="descripcion_canasta" name="descripcion" class="form-control" placeholder="" value="">
                                        </div>
                                        <div class="input-group input-group-outline mb-3 ">
                                            <label class="form-label">Equivalencia</label>
                                            <input type="text" id="equivalencia_canasta" name="descripcion" class="form-control" placeholder="" value="">
                                        </div>
                                       
                                        <div class="text-center">
                                            <a class="btn bg-gradient-primary w-100 my-4 mb-2" onclick="create_canasta()">Crear</a>
                                        </div>

                                        </form>
                                    </div>
        </div>
    </div>
</div>                   
<?php footerAdmin($data); ?>