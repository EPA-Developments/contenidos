<?php
/*
 * Lateral de los artículos: el pedido de turno con Segunda Opinión Médica.
 *
 * Antes había un formulario «Book An Appointment» que mandaba nombre, teléfono y ubicación
 * a una API de terceros (Medicover Hospitals, India). Lo reemplaza el bloque de turnos de
 * SOM (include/som-turnos.php): WhatsApp a Recepción o el portal, sin pedir datos acá.
 * El id `book-an-appointment` se mantiene porque muchas páginas enlazan a esa ancla.
 */
include_once __DIR__ . '/som-turnos.php';
?>
							<div class="article-leave-comment" id="book-an-appointment">
								<?= som_cta_turno() ?>
							</div>
                        </aside>
                    </div>
