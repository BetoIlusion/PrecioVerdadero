<x-app-layout>
<!-- CU12 Procesar pagos -->
<div class="procesar-pago">
  <h2>Procesar Pago</h2>

  <form>
    <label for="nombre">Nombre del titular</label>
    <input type="text" id="nombre" placeholder="Ej: Juan Pérez" required />

    <label for="tarjeta">Número de tarjeta</label>
    <input type="text" id="tarjeta" maxlength="16" placeholder="1234 5678 9012 3456" required />

    <label for="vencimiento">Fecha de vencimiento</label>
    <input type="month" id="vencimiento" required />

    <label for="cvv">CVV</label>
    <input type="text" id="cvv" maxlength="4" placeholder="123" required />

    <label for="monto">Monto</label>
    <input type="number" id="monto" step="0.01" placeholder="Bs." required />

    <label for="metodo">Método de pago</label>
    <select id="metodo" required>
      <option value="">Seleccionar...</option>
      <option value="tarjeta">Tarjeta de Crédito</option>
      <option value="qr">QR - Transferencia</option>
      <option value="efectivo">Pago en efectivo</option>
    </select>

    <button type="submit">Confirmar Pago</button>
  </form>
</div>

<style>
.procesar-pago {
  max-width: 500px;
  margin: 2rem auto;
  font-family: 'Segoe UI', sans-serif;
  background-color: #f7f7f7;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.procesar-pago h2 {
  margin-bottom: 1rem;
  color: #333;
}

.procesar-pago form label {
  display: block;
  margin-top: 1rem;
  font-weight: 600;
}

.procesar-pago input,
.procesar-pago select {
  width: 100%;
  padding: 0.6rem;
  margin-top: 0.4rem;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 1rem;
}

.procesar-pago button {
  margin-top: 1.5rem;
  width: 100%;
  padding: 0.8rem;
  background-color: #28a745;
  color: white;
  font-size: 1rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.procesar-pago button:hover {
  background-color: #218838;
}
</style>

</x-app-layout>