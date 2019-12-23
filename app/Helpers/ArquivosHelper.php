<?php

use App\Models\Ca\CaAlunoDoctoPend;
use Illuminate\Support\Facades\Storage;

function getArquivo($dsc_link_arquivo)
{
    if ($dsc_link_arquivo != '') {
        return Storage::disk('s3')->url($dsc_link_arquivo);
    }
    return '';
}

function storeToS3($arquivo, $path)
{
    $arquivoPath = $path . $arquivo->getClientOriginalName();
    Storage::disk('s3')->put($arquivoPath, file_get_contents($arquivo), 'public');

    return $arquivo->getClientOriginalName();
}

function storeCustomToS3($arquivo, $path, $complemento = '')
{
    $dsc_link =  $complemento . $arquivo->getClientOriginalName();
    $arquivoPath = "/" .  $path . $dsc_link;

    Storage::disk('s3')->put($arquivoPath, file_get_contents($arquivo), 'public');

    return $dsc_link;
}

function destroy($dsc_link_arquivo, $path)
{
    return Storage::disk('s3')->delete($path . $dsc_link_arquivo);
}

function isDocPendente($cod_docto){
    if(CaAlunoDoctoPend::where(['cod_ra' => getRaAluno(), 'cod_tp_docto' => $cod_docto])->first())
        return FALSE;
    else
        return TRUE;

    return TRUE;
}
