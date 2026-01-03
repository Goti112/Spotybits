<?php

class pedido {
    private int $id_pedido;
    private string $fecha;
    private string $importe_total;
    private float $estado;
    private int $id_usuario;
    private ?int $id_oferta;

    public function __construct(int $id_pedido, string $fecha, string $importe_total, float $estado, int $id_usuario, ?int $id_oferta) {
        $this->id_pedido = $id_pedido;
        $this->fecha = $fecha;
        $this->importe_total = $importe_total;
        $this->estado = $estado;
        $this->id_usuario = $id_usuario;
        $this->id_oferta = $id_oferta;
    }

    public function getIdPedido(): int {
        return $this->id_pedido;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    public function getImporteTotal(): string {
        return $this->importe_total;
    }

    public function getEstado(): float {
        return $this->estado;
    }

    public function getIdUsuario(): int {
        return $this->id_usuario;
    }

    public function getIdOferta(): ?int {
        return $this->id_oferta;
    }

    public function setEstado(float $estado): void {
        $this->estado = $estado;
    }



    

   
}
?>
