<?php
/**
 * D&D 5e Character Sheet (Snippet for WordPress)
 *
 * Como usar:
 * 1) Cole este arquivo no plugin "Code Snippets" ou no functions.php do seu tema.
 * 2) Use o shortcode [dnd5e_sheet] em qualquer página/post.
 */

if (!defined('ABSPATH')) {
    exit;
}

function dnd5e_sheet_shortcode(): string
{
    $nonce = wp_create_nonce('dnd5e_sheet');
    $abilities = [
        'str' => 'Força',
        'dex' => 'Destreza',
        'con' => 'Constituição',
        'int' => 'Inteligência',
        'wis' => 'Sabedoria',
        'cha' => 'Carisma',
    ];
    $skills = [
        ['key' => 'acrobatics', 'label' => 'Acrobacia', 'ability' => 'dex'],
        ['key' => 'animalHandling', 'label' => 'Adestrar Animais', 'ability' => 'wis'],
        ['key' => 'arcana', 'label' => 'Arcanismo', 'ability' => 'int'],
        ['key' => 'athletics', 'label' => 'Atletismo', 'ability' => 'str'],
        ['key' => 'deception', 'label' => 'Enganação', 'ability' => 'cha'],
        ['key' => 'history', 'label' => 'História', 'ability' => 'int'],
        ['key' => 'insight', 'label' => 'Intuição', 'ability' => 'wis'],
        ['key' => 'intimidation', 'label' => 'Intimidação', 'ability' => 'cha'],
        ['key' => 'investigation', 'label' => 'Investigação', 'ability' => 'int'],
        ['key' => 'medicine', 'label' => 'Medicina', 'ability' => 'wis'],
        ['key' => 'nature', 'label' => 'Natureza', 'ability' => 'int'],
        ['key' => 'perception', 'label' => 'Percepção', 'ability' => 'wis'],
        ['key' => 'performance', 'label' => 'Performance', 'ability' => 'cha'],
        ['key' => 'persuasion', 'label' => 'Persuasão', 'ability' => 'cha'],
        ['key' => 'religion', 'label' => 'Religião', 'ability' => 'int'],
        ['key' => 'sleightOfHand', 'label' => 'Prestidigitação', 'ability' => 'dex'],
        ['key' => 'stealth', 'label' => 'Furtividade', 'ability' => 'dex'],
        ['key' => 'survival', 'label' => 'Sobrevivência', 'ability' => 'wis'],
    ];
    $skills_by_ability = [];
    foreach ($skills as $skill) {
        $skills_by_ability[$skill['ability']][] = $skill;
    }
    ob_start();
    ?>
    <div class="dnd5e-sheet" data-nonce="<?php echo esc_attr($nonce); ?>" data-ajax="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
        <button type="button" class="dnd5e-theme-toggle" data-action="toggle-theme" aria-pressed="false">Tema escuro</button>
        <h2>Ficha D&amp;D 5e</h2>

        <section class="dnd5e-section">
            <h3>Identidade</h3>
            <div class="dnd5e-grid dnd5e-grid-3">
                <label>Nome<input type="text" data-path="identity.name"></label>
                <label>Jogador<input type="text" data-path="identity.player"></label>
                <label>Classe<input type="text" data-path="identity.class"></label>
                <label>Raça<input type="text" data-path="identity.race"></label>
                <label>Antecedente<input type="text" data-path="identity.background"></label>
                <label>Alinhamento<input type="text" data-path="identity.alignment"></label>
                <label>Nível<input type="number" min="1" value="1" data-path="identity.level" data-field="level"></label>
                <label>Experiência<input type="number" min="0" data-path="identity.xp"></label>
            </div>
        </section>

        <section class="dnd5e-section">
            <h3>Atributos e Bônus</h3>
            <div class="dnd5e-grid dnd5e-grid-3">
                <?php foreach ($abilities as $key => $label) : ?>
                    <div class="dnd5e-ability">
                        <strong><?php echo esc_html($label); ?></strong>
                        <div class="dnd5e-grid dnd5e-grid-2">
                            <label>Valor
                                <input type="number" min="1" max="30" value="10" data-field="ability-score" data-ability="<?php echo esc_attr($key); ?>" data-path="abilities.<?php echo esc_attr($key); ?>.score">
                            </label>
                            <label>Mod
                                <input type="number" readonly data-field="ability-mod" data-ability="<?php echo esc_attr($key); ?>" data-path="abilities.<?php echo esc_attr($key); ?>.mod">
                            </label>
                        </div>
                        <div class="dnd5e-save-inline" data-save="<?php echo esc_attr($key); ?>">
                            <strong>Teste de Resistência</strong>
                            <label>Prof.
                                <input type="checkbox" data-field="save-prof" data-ability="<?php echo esc_attr($key); ?>" data-path="saves.<?php echo esc_attr($key); ?>.proficient">
                            </label>
                            <label>Extra
                                <input type="number" value="0" data-field="save-misc" data-ability="<?php echo esc_attr($key); ?>" data-path="saves.<?php echo esc_attr($key); ?>.misc">
                            </label>
                            <label>Total
                                <input type="number" readonly data-field="save-total" data-ability="<?php echo esc_attr($key); ?>" data-path="saves.<?php echo esc_attr($key); ?>.total">
                            </label>
                        </div>
                        <?php if (!empty($skills_by_ability[$key])) : ?>
                            <div class="dnd5e-skill-group">
                                <strong>Perícias</strong>
                                <?php foreach ($skills_by_ability[$key] as $skill) : ?>
                                    <div class="dnd5e-skill-inline" data-skill="<?php echo esc_attr($skill['key']); ?>" data-ability="<?php echo esc_attr($skill['ability']); ?>">
                                        <span><?php echo esc_html($skill['label']); ?></span>
                                        <div class="dnd5e-skill-fields">
                                            <label>Prof.
                                                <input type="checkbox" data-field="skill-prof" data-skill="<?php echo esc_attr($skill['key']); ?>" data-path="skills.<?php echo esc_attr($skill['key']); ?>.proficient">
                                            </label>
                                            <label>Extra
                                                <input type="number" value="0" data-field="skill-misc" data-skill="<?php echo esc_attr($skill['key']); ?>" data-path="skills.<?php echo esc_attr($skill['key']); ?>.misc">
                                            </label>
                                            <label>Total
                                                <input type="number" readonly data-field="skill-total" data-skill="<?php echo esc_attr($skill['key']); ?>" data-path="skills.<?php echo esc_attr($skill['key']); ?>.total">
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="dnd5e-section">
            <h3>Bônus e Defesas</h3>
            <div class="dnd5e-grid dnd5e-grid-3">
                <label>Bônus de Proficiência
                    <input type="number" readonly data-field="proficiency" data-path="derived.proficiency">
                </label>
                <label>Iniciativa
                    <input type="number" readonly data-field="initiative" data-path="derived.initiative">
                </label>
                <label>Deslocamento
                    <input type="number" min="0" data-path="derived.speed">
                </label>
                <label>CA
                    <input type="number" min="0" data-path="derived.armorClass">
                </label>
                <label>PV Máximo
                    <input type="number" min="0" data-path="derived.hpMax">
                </label>
                <label>PV Atual
                    <input type="number" min="0" data-path="derived.hpCurrent">
                </label>
                <label>Dados de Vida
                    <input type="text" data-path="derived.hitDice" placeholder="ex: 1d8">
                </label>
                <label>Percepção Passiva
                    <input type="number" readonly data-field="passive-perception" data-path="derived.passivePerception">
                </label>
                <label>Visibilidade (penumbra)
                    <input type="text" data-path="senses.dimLight" placeholder="ex: 18 m">
                </label>
                <label>Visibilidade (escuro)
                    <input type="text" data-path="senses.darkness" placeholder="ex: 9 m">
                </label>
            </div>
        </section>

        <section class="dnd5e-section">
            <h3>Combate</h3>
            <div class="dnd5e-grid dnd5e-grid-2">
                <label class="dnd5e-combat-notes">Armas/Ataques (descrição)
                    <textarea rows="4" data-path="combat.attacks"></textarea>
                </label>
                <div class="dnd5e-attack-actions">
                    <button type="button" data-action="add-attack">Adicionar ataque</button>
                </div>
                <div class="dnd5e-attack-list" data-attack-list></div>
                <div class="dnd5e-magic-block">
                    <strong>Magia (combate)</strong>
                    <label>CD de Magia
                        <input type="number" readonly data-field="spell-save" data-path="spells.saveDC">
                    </label>
                    <label>Atributo de Conjuração
                        <select data-field="spell-ability" data-path="spells.ability">
                            <option value="int">Inteligência</option>
                            <option value="wis">Sabedoria</option>
                            <option value="cha">Carisma</option>
                        </select>
                    </label>
                    <label>Ataque Mágico
                        <input type="number" readonly data-field="spell-attack" data-path="spells.attackBonus">
                    </label>
                </div>
            </div>
        </section>
        <template id="dnd5e-attack-template">
            <div class="dnd5e-attack-block" data-attack-block>
                <div class="dnd5e-attack-header">
                    <strong data-attack-title>Ataque</strong>
                    <button type="button" data-action="remove-attack">Remover</button>
                </div>
                <label>Nome
                    <input type="text" data-path-template="combat.attacksList.__index__.name">
                </label>
                <div class="dnd5e-grid dnd5e-grid-3">
                    <label>Atributo (ataque)
                        <select data-field="attack-ability" data-path-template="combat.attacksList.__index__.attackAbility">
                            <option value="str">Força</option>
                            <option value="dex">Destreza</option>
                            <option value="con">Constituição</option>
                            <option value="int">Inteligência</option>
                            <option value="wis">Sabedoria</option>
                            <option value="cha">Carisma</option>
                        </select>
                    </label>
                    <label>Prof.
                        <input type="checkbox" data-field="attack-prof" data-path-template="combat.attacksList.__index__.proficient">
                    </label>
                    <label>Extra (ataque)
                        <input type="number" value="0" data-field="attack-misc" data-path-template="combat.attacksList.__index__.attackMisc">
                    </label>
                    <label>Total ataque
                        <input type="number" readonly data-field="attack-total" data-path-template="combat.attacksList.__index__.attackTotal">
                    </label>
                    <label>Dano (dados)
                        <input type="text" placeholder="ex: 1d8" data-path-template="combat.attacksList.__index__.damageDice">
                    </label>
                    <label>Atributo (dano)
                        <select data-field="damage-ability" data-path-template="combat.attacksList.__index__.damageAbility">
                            <option value="str">Força</option>
                            <option value="dex">Destreza</option>
                            <option value="con">Constituição</option>
                            <option value="int">Inteligência</option>
                            <option value="wis">Sabedoria</option>
                            <option value="cha">Carisma</option>
                        </select>
                    </label>
                    <label>Extra (dano)
                        <input type="number" value="0" data-field="damage-misc" data-path-template="combat.attacksList.__index__.damageMisc">
                    </label>
                    <label>Bônus dano
                        <input type="number" readonly data-field="damage-total" data-path-template="combat.attacksList.__index__.damageTotal">
                    </label>
                </div>
            </div>
        </template>

        <section class="dnd5e-section">
            <h3>Magias</h3>
            <div class="dnd5e-grid dnd5e-grid-2">
                <div class="dnd5e-option" data-option>
                    <label class="dnd5e-inline">
                        <input type="checkbox" data-path="spells.options.spellcasting.enabled" data-option-toggle>
                        <strong>1) Spellcasting (slots)</strong>
                    </label>
                    <div class="dnd5e-option-body">
                        <div class="dnd5e-grid dnd5e-grid-2">
                            <label>Truques
                                <textarea rows="3" data-path="spells.options.spellcasting.cantrips"></textarea>
                            </label>
                            <label>Magias Conhecidas
                                <textarea rows="3" data-path="spells.options.spellcasting.known"></textarea>
                            </label>
                            <label>Magias Preparadas
                                <textarea rows="3" data-path="spells.options.spellcasting.prepared"></textarea>
                            </label>
                        </div>
                        <div class="dnd5e-slot-grid">
                            <div class="dnd5e-slot-row dnd5e-slot-header">
                                <span>Nível</span>
                                <span>Atuais</span>
                                <span>Máx.</span>
                            </div>
                            <?php for ($level = 1; $level <= 9; $level++) : ?>
                                <div class="dnd5e-slot-row">
                                    <span><?php echo esc_html($level . 'º'); ?></span>
                                    <input type="number" min="0" data-path="spells.options.spellcasting.slots.level<?php echo esc_attr($level); ?>.current">
                                    <input type="number" min="0" data-path="spells.options.spellcasting.slots.level<?php echo esc_attr($level); ?>.max">
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="dnd5e-option" data-option>
                    <label class="dnd5e-inline">
                        <input type="checkbox" data-path="spells.options.pactMagic.enabled" data-option-toggle>
                        <strong>2) Pact Magic</strong>
                    </label>
                    <div class="dnd5e-option-body">
                        <div class="dnd5e-grid dnd5e-grid-2">
                            <label>Nível do slot
                                <input type="number" min="1" max="5" data-path="spells.options.pactMagic.slotLevel">
                            </label>
                            <label>Slots disponíveis
                                <input type="number" min="0" data-path="spells.options.pactMagic.slots">
                            </label>
                        </div>
                        <label>Magias Conhecidas
                            <textarea rows="3" data-path="spells.options.pactMagic.known"></textarea>
                        </label>
                        <label>Invocações/Notas
                            <textarea rows="3" data-path="spells.options.pactMagic.notes"></textarea>
                        </label>
                    </div>
                </div>
                <div class="dnd5e-option" data-option>
                    <label class="dnd5e-inline">
                        <input type="checkbox" data-path="spells.options.ritualCasting.enabled" data-option-toggle>
                        <strong>3) Ritual Casting</strong>
                    </label>
                    <div class="dnd5e-option-body">
                        <label>Lista de rituais
                            <textarea rows="4" data-path="spells.options.ritualCasting.list"></textarea>
                        </label>
                        <label>Notas
                            <textarea rows="3" data-path="spells.options.ritualCasting.notes" placeholder="Regras de ritual, livro, preparação..."></textarea>
                        </label>
                    </div>
                </div>
                <div class="dnd5e-option" data-option>
                    <label class="dnd5e-inline">
                        <input type="checkbox" data-path="spells.options.features.enabled" data-option-toggle>
                        <strong>4) Traços mágicos (features)</strong>
                    </label>
                    <div class="dnd5e-option-body">
                        <label>Habilidades e usos
                            <textarea rows="4" data-path="spells.options.features.notes" placeholder="Habilidades mágicas e usos..."></textarea>
                        </label>
                    </div>
                </div>
                <div class="dnd5e-option" data-option>
                    <label class="dnd5e-inline">
                        <input type="checkbox" data-path="spells.options.raceFeats.enabled" data-option-toggle>
                        <strong>5) Magias por raça/talento/boon</strong>
                    </label>
                    <div class="dnd5e-option-body">
                        <label>Magias e usos
                            <textarea rows="4" data-path="spells.options.raceFeats.notes" placeholder="Magias, frequências, restrições..."></textarea>
                        </label>
                    </div>
                </div>
                <div class="dnd5e-option" data-option>
                    <label class="dnd5e-inline">
                        <input type="checkbox" data-path="spells.options.magicItems.enabled" data-option-toggle>
                        <strong>6) Itens mágicos</strong>
                    </label>
                    <div class="dnd5e-option-body">
                        <label>Itens, cargas, usos
                            <textarea rows="4" data-path="spells.options.magicItems.notes" placeholder="Itens, cargas, usos..."></textarea>
                        </label>
                    </div>
                </div>
            </div>
        </section>

        <section class="dnd5e-section">
            <h3>Equipamento e Tesouro</h3>
            <div class="dnd5e-grid dnd5e-grid-2">
                <label>Itens
                    <textarea rows="6" data-path="equipment.items"></textarea>
                </label>
                <label>Moedas
                    <input type="text" data-path="equipment.coins" placeholder="PC, PP, PO, PE, PL">
                </label>
                <label>Tesouro
                    <textarea rows="4" data-path="equipment.treasure"></textarea>
                </label>
            </div>
        </section>

        <section class="dnd5e-section">
            <h3>Personalidade e História</h3>
            <div class="dnd5e-grid dnd5e-grid-2">
                <label>Traços de Personalidade
                    <textarea rows="3" data-path="personality.traits"></textarea>
                </label>
                <label>Ideais
                    <textarea rows="3" data-path="personality.ideals"></textarea>
                </label>
                <label>Vínculos
                    <textarea rows="3" data-path="personality.bonds"></textarea>
                </label>
                <label>Defeitos
                    <textarea rows="3" data-path="personality.flaws"></textarea>
                </label>
                <label>Idiomas/Proficiências Extras
                    <textarea rows="3" data-path="features.languages"></textarea>
                </label>
                <label>Características de Classe/Raça
                    <textarea rows="4" data-path="features.traits"></textarea>
                </label>
            </div>
        </section>

        <section class="dnd5e-section dnd5e-actions">
            <button type="button" data-action="save-local">Salvar no navegador</button>
            <button type="button" data-action="load-local">Carregar do navegador</button>
            <button type="button" data-action="download-json">Baixar JSON</button>
            <button type="button" data-action="import-json">Importar JSON</button>
            <button type="button" data-action="save-server">Salvar no servidor</button>
            <span class="dnd5e-status" aria-live="polite"></span>
        </section>
        <input type="file" accept="application/json" data-action="import-file" hidden>
    </div>

    <style>
        .dnd5e-sheet {
            font-family: "Inter", "Segoe UI", system-ui, sans-serif;
            border: 1px solid #e5e7eb;
            padding: 20px;
            border-radius: 12px;
            background: #ffffff;
            color: #111827;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            width: 100vw;
            max-width: 100vw;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            position: relative;
        }
        .dnd5e-theme-toggle {
            position: absolute;
            top: 16px;
            right: 16px;
            padding: 6px 12px;
            border-radius: 999px;
            border: 1px solid #cbd5f5;
            background: #eef2ff;
            color: #3730a3;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }
        .dnd5e-theme-toggle:hover {
            background: #e0e7ff;
        }
        .dnd5e-sheet h2 {
            margin: 0 0 16px;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: -0.01em;
        }
        .dnd5e-section {
            margin-bottom: 22px;
            padding: 16px;
            border-radius: 10px;
            border: 1px solid #f1f5f9;
            background: #f8fafc;
        }
        .dnd5e-section h3 {
            margin: 0 0 14px;
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
        }
        .dnd5e-grid { display: grid; gap: 14px; }
        .dnd5e-grid-3 { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
        .dnd5e-grid-2 { grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
        .dnd5e-sheet label {
            display: flex;
            flex-direction: column;
            font-size: 13px;
            font-weight: 500;
            gap: 6px;
            color: #475569;
        }
        .dnd5e-sheet input,
        .dnd5e-sheet textarea,
        .dnd5e-sheet select {
            padding: 8px 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: #ffffff;
            color: #0f172a;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            width: 100%;
            box-sizing: border-box;
        }
        .dnd5e-sheet input:focus,
        .dnd5e-sheet textarea:focus,
        .dnd5e-sheet select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        .dnd5e-ability,
        .dnd5e-save,
        .dnd5e-skill {
            border: 1px solid #e2e8f0;
            padding: 12px;
            border-radius: 10px;
            background: #ffffff;
        }
        .dnd5e-ability .dnd5e-grid {
            gap: 10px;
        }
        .dnd5e-ability input[data-field="ability-score"],
        .dnd5e-ability input[data-field="ability-mod"] {
            width: 72px;
            max-width: 100%;
            padding: 6px 8px;
            text-align: center;
        }
        .dnd5e-save-inline,
        .dnd5e-skill-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            border-top: 1px dashed #e2e8f0;
            padding-top: 10px;
            padding: 10px;
            border-radius: 8px;
            background: #f8fafc;
        }
        .dnd5e-save-inline > strong,
        .dnd5e-skill-group > strong {
            font-size: 13px;
            color: #0f172a;
        }
        .dnd5e-save-inline label,
        .dnd5e-skill-inline label {
            font-size: 11px;
        }
        .dnd5e-skill-inline {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .dnd5e-skill-inline span {
            font-size: 12px;
            color: #0f172a;
        }
        .dnd5e-skill-fields {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .dnd5e-ability strong,
        .dnd5e-save strong,
        .dnd5e-skill strong {
            font-size: 14px;
            color: #0f172a;
        }
        .dnd5e-attack-block {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .dnd5e-attack-block strong {
            font-size: 14px;
            color: #0f172a;
        }
        .dnd5e-attack-block .dnd5e-grid {
            gap: 10px;
        }
        .dnd5e-attack-block label {
            font-size: 12px;
        }
        .dnd5e-combat-notes {
            grid-column: 1 / -1;
        }
        .dnd5e-combat-notes textarea {
            min-height: 120px;
        }
        .dnd5e-attack-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .dnd5e-attack-header button,
        .dnd5e-attack-actions button {
            padding: 6px 10px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #f1f5f9;
            color: #0f172a;
            font-weight: 600;
            cursor: pointer;
        }
        .dnd5e-attack-actions {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            grid-column: 1 / -1;
        }
        .dnd5e-attack-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 12px;
            grid-column: 1 / -1;
        }
        .dnd5e-magic-block {
            border: 1px dashed #cbd5f5;
            border-radius: 10px;
            padding: 12px;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .dnd5e-magic-block strong {
            font-size: 14px;
            color: #0f172a;
        }
        .dnd5e-option {
            display: flex;
            flex-direction: column;
            gap: 8px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px;
            background: #ffffff;
        }
        .dnd5e-option-body {
            display: none;
            flex-direction: column;
            gap: 10px;
        }
        .dnd5e-option.is-active .dnd5e-option-body {
            display: flex;
        }
        .dnd5e-slot-grid {
            display: grid;
            gap: 8px;
            border: 1px dashed #e2e8f0;
            border-radius: 8px;
            padding: 10px;
            background: #f8fafc;
        }
        .dnd5e-slot-row {
            display: grid;
            grid-template-columns: 70px 1fr 1fr;
            gap: 8px;
            align-items: center;
            font-size: 12px;
            color: #475569;
        }
        .dnd5e-slot-header {
            font-weight: 600;
            color: #0f172a;
        }
        .dnd5e-inline {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #0f172a;
        }
        .dnd5e-skill small {
            color: #94a3b8;
            font-weight: 500;
        }
        .dnd5e-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            padding: 12px;
            background: #ffffff;
            border: 1px dashed #cbd5f5;
        }
        .dnd5e-actions button {
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid #cbd5f5;
            background: #eef2ff;
            color: #3730a3;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.2s ease;
        }
        .dnd5e-actions button:hover {
            background: #e0e7ff;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.18);
            transform: translateY(-1px);
        }
        .dnd5e-status {
            font-size: 13px;
            color: #475569;
        }
        .dnd5e-sheet.dnd5e-theme-dark {
            background: #0f172a;
            color: #e2e8f0;
            border-color: #1e293b;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.5);
        }
        .dnd5e-sheet.dnd5e-theme-dark h2,
        .dnd5e-sheet.dnd5e-theme-dark h3,
        .dnd5e-sheet.dnd5e-theme-dark strong,
        .dnd5e-sheet.dnd5e-theme-dark span {
            color: #f1f5f9;
        }
        .dnd5e-sheet.dnd5e-theme-dark label {
            color: #cbd5f5;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-slot-header,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-inline {
            color: #e2e8f0;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-skill small {
            color: #94a3b8;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-section {
            background: #111827;
            border-color: #1f2937;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-ability,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-save,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-skill,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-attack-block,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-magic-block,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-option {
            background: #0b1220;
            border-color: #1e293b;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-save-inline,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-skill-group {
            background: #0f172a;
            border-color: #24324a;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-slot-grid {
            background: #0f172a;
            border-color: #24324a;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-attack-header button,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-attack-actions button {
            background: #1e293b;
            border-color: #334155;
            color: #e2e8f0;
        }
        .dnd5e-sheet.dnd5e-theme-dark input,
        .dnd5e-sheet.dnd5e-theme-dark select,
        .dnd5e-sheet.dnd5e-theme-dark textarea {
            background: #0b1220;
            border-color: #24324a;
            color: #e2e8f0;
        }
        .dnd5e-sheet.dnd5e-theme-dark input::placeholder,
        .dnd5e-sheet.dnd5e-theme-dark textarea::placeholder {
            color: #64748b;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-sheet input:focus,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-sheet textarea:focus,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-sheet select:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.35);
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-actions {
            background: #0b1220;
            border-color: #1e293b;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-actions button,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-theme-toggle {
            background: #1e293b;
            border-color: #334155;
            color: #e2e8f0;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-actions button:hover,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-theme-toggle:hover {
            background: #334155;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-status {
            color: #94a3b8;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-save-inline,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-skill-group {
            border-top-color: #24324a;
        }
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-ability,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-save,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-skill,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-attack-block,
        .dnd5e-sheet.dnd5e-theme-dark .dnd5e-section {
            color: #e2e8f0;
        }
    </style>

    <script>
        (() => {
            const root = document.currentScript.parentElement.querySelector('.dnd5e-sheet');
            if (!root || !root.classList.contains('dnd5e-sheet')) {
                return;
            }

            const statusEl = root.querySelector('.dnd5e-status');
            const themeToggle = root.querySelector('[data-action="toggle-theme"]');
            const abilityScores = Array.from(root.querySelectorAll('[data-field="ability-score"]'));
            const abilityMods = Array.from(root.querySelectorAll('[data-field="ability-mod"]'));
            const proficiencyField = root.querySelector('[data-field="proficiency"]');
            const initiativeField = root.querySelector('[data-field="initiative"]');
            const saveTotalFields = Array.from(root.querySelectorAll('[data-field="save-total"]'));
            const skillTotalFields = Array.from(root.querySelectorAll('[data-field="skill-total"]'));
            const passivePerceptionField = root.querySelector('[data-field="passive-perception"]');
            const spellAbilityField = root.querySelector('[data-field="spell-ability"]');
            const spellSaveField = root.querySelector('[data-field="spell-save"]');
            const spellAttackField = root.querySelector('[data-field="spell-attack"]');
            const attackList = root.querySelector('[data-attack-list]');
            const attackTemplate = root.querySelector('#dnd5e-attack-template');
            const addAttackButton = root.querySelector('[data-action="add-attack"]');

            const getAbilityMod = (score) => Math.floor((score - 10) / 2);
            const getProficiency = (level) => 2 + Math.floor((Math.max(1, level) - 1) / 4);

            const readNumber = (input, fallback = 0) => {
                const value = Number(input.value);
                return Number.isFinite(value) ? value : fallback;
            };

            const setStatus = (message, isError = false) => {
                statusEl.textContent = message;
                statusEl.style.color = isError ? '#b00020' : '#2c662d';
            };

            const applyTheme = (theme) => {
                if (!themeToggle) {
                    return;
                }
                const isDark = theme === 'dark';
                root.classList.toggle('dnd5e-theme-dark', isDark);
                themeToggle.textContent = isDark ? 'Tema claro' : 'Tema escuro';
                themeToggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
                localStorage.setItem('dnd5e-theme', theme);
            };

            const storedTheme = localStorage.getItem('dnd5e-theme');
            if (storedTheme === 'dark' || storedTheme === 'light') {
                applyTheme(storedTheme);
            }
            if (themeToggle) {
                themeToggle.addEventListener('click', () => {
                    const nextTheme = root.classList.contains('dnd5e-theme-dark') ? 'light' : 'dark';
                    applyTheme(nextTheme);
                });
            }

            const getNextAttackIndex = () => {
                const indices = Array.from(root.querySelectorAll('[data-attack-index]'))
                    .map((el) => Number(el.dataset.attackIndex))
                    .filter((value) => Number.isFinite(value));
                return indices.length ? Math.max(...indices) + 1 : 1;
            };

            const normalizeLegacyAttacks = (data) => {
                if (!data?.combat) {
                    return;
                }
                if (data.combat.attacksList) {
                    return;
                }
                const legacy = {};
                if (data.combat.attack1) {
                    legacy['1'] = data.combat.attack1;
                }
                if (data.combat.attack2) {
                    legacy['2'] = data.combat.attack2;
                }
                if (Object.keys(legacy).length) {
                    data.combat.attacksList = legacy;
                }
            };

            const createAttackBlock = (index) => {
                if (!attackTemplate || !attackList) {
                    return null;
                }
                const fragment = attackTemplate.content.cloneNode(true);
                const block = fragment.querySelector('[data-attack-block]');
                const title = fragment.querySelector('[data-attack-title]');
                if (block) {
                    block.dataset.attackIndex = String(index);
                }
                if (title) {
                    title.textContent = `Ataque ${index}`;
                }
                const fields = fragment.querySelectorAll('[data-path-template]');
                fields.forEach((field) => {
                    const templatePath = field.dataset.pathTemplate;
                    if (!templatePath) {
                        return;
                    }
                    field.dataset.path = templatePath.replace('__index__', index);
                    delete field.dataset.pathTemplate;
                });
                const removeButton = fragment.querySelector('[data-action="remove-attack"]');
                if (removeButton) {
                    removeButton.addEventListener('click', () => {
                        const target = removeButton.closest('[data-attack-block]');
                        if (target) {
                            target.remove();
                            updateDerived();
                            autosave();
                        }
                    });
                }
                attackList.appendChild(fragment);
                return block;
            };

            const ensureDefaultAttack = () => {
                if (!attackList) {
                    return;
                }
                if (!attackList.querySelector('[data-attack-block]')) {
                    createAttackBlock(1);
                }
            };

            const updateDerived = () => {
                const levelInput = root.querySelector('[data-field="level"]');
                const level = levelInput ? readNumber(levelInput, 1) : 1;
                const proficiency = getProficiency(level);
                proficiencyField.value = proficiency;

                const modMap = {};
                abilityScores.forEach((input) => {
                    const ability = input.dataset.ability;
                    const score = readNumber(input, 10);
                    const mod = getAbilityMod(score);
                    modMap[ability] = mod;
                    const modField = abilityMods.find((field) => field.dataset.ability === ability);
                    if (modField) {
                        modField.value = mod;
                    }
                });

                initiativeField.value = modMap.dex ?? 0;

                saveTotalFields.forEach((field) => {
                    const ability = field.dataset.ability;
                    const prof = root.querySelector(`[data-field="save-prof"][data-ability="${ability}"]`);
                    const misc = root.querySelector(`[data-field="save-misc"][data-ability="${ability}"]`);
                    const total = (modMap[ability] ?? 0)
                        + (prof && prof.checked ? proficiency : 0)
                        + (misc ? readNumber(misc, 0) : 0);
                    field.value = total;
                });

                skillTotalFields.forEach((field) => {
                    const skill = field.dataset.skill;
                    const skillWrap = root.querySelector(`[data-skill="${skill}"]`);
                    const ability = skillWrap ? skillWrap.dataset.ability : 'str';
                    const prof = root.querySelector(`[data-field="skill-prof"][data-skill="${skill}"]`);
                    const misc = root.querySelector(`[data-field="skill-misc"][data-skill="${skill}"]`);
                    const total = (modMap[ability] ?? 0)
                        + (prof && prof.checked ? proficiency : 0)
                        + (misc ? readNumber(misc, 0) : 0);
                    field.value = total;
                });

                const perceptionField = root.querySelector('[data-field="skill-total"][data-skill="perception"]');
                passivePerceptionField.value = 10 + (perceptionField ? readNumber(perceptionField, 0) : 0);

                const attackBlocks = root.querySelectorAll('[data-attack-block]');
                attackBlocks.forEach((block) => {
                    const abilitySelect = block.querySelector('[data-field="attack-ability"]');
                    const prof = block.querySelector('[data-field="attack-prof"]');
                    const misc = block.querySelector('[data-field="attack-misc"]');
                    const totalField = block.querySelector('[data-field="attack-total"]');
                    const ability = abilitySelect ? abilitySelect.value : 'str';
                    if (totalField) {
                        totalField.value = (modMap[ability] ?? 0)
                            + (prof && prof.checked ? proficiency : 0)
                            + (misc ? readNumber(misc, 0) : 0);
                    }
                    const damageAbilitySelect = block.querySelector('[data-field="damage-ability"]');
                    const damageMisc = block.querySelector('[data-field="damage-misc"]');
                    const damageTotalField = block.querySelector('[data-field="damage-total"]');
                    const damageAbility = damageAbilitySelect ? damageAbilitySelect.value : 'str';
                    if (damageTotalField) {
                        damageTotalField.value = (modMap[damageAbility] ?? 0)
                            + (damageMisc ? readNumber(damageMisc, 0) : 0);
                    }
                });

                const spellAbility = spellAbilityField.value;
                const spellMod = modMap[spellAbility] ?? 0;
                spellSaveField.value = 8 + proficiency + spellMod;
                spellAttackField.value = proficiency + spellMod;
            };

            const getFormData = () => {
                const data = {};
                const setPath = (path, value) => {
                    if (!path) return;
                    const keys = path.split('.');
                    let current = data;
                    keys.forEach((key, index) => {
                        if (index === keys.length - 1) {
                            current[key] = value;
                        } else {
                            current[key] = current[key] || {};
                            current = current[key];
                        }
                    });
                };

                const inputs = root.querySelectorAll('input, textarea, select');
                inputs.forEach((input) => {
                    const path = input.dataset.path;
                    if (!path) return;
                    if (input.type === 'checkbox') {
                        setPath(path, input.checked);
                    } else {
                        setPath(path, input.value);
                    }
                });

                return data;
            };

            const applyFormData = (data) => {
                normalizeLegacyAttacks(data);
                if (data?.combat?.attacksList && attackList) {
                    attackList.innerHTML = '';
                    Object.keys(data.combat.attacksList).forEach((key) => {
                        const index = Number(key);
                        if (Number.isFinite(index)) {
                            createAttackBlock(index);
                        }
                    });
                }
                ensureDefaultAttack();
                const inputs = root.querySelectorAll('input, textarea, select');
                inputs.forEach((input) => {
                    const path = input.dataset.path;
                    if (!path) return;
                    const keys = path.split('.');
                    let current = data;
                    keys.forEach((key) => {
                        current = current ? current[key] : undefined;
                    });
                    if (current === undefined || current === null) {
                        return;
                    }
                    if (input.type === 'checkbox') {
                        input.checked = Boolean(current);
                    } else {
                        input.value = current;
                    }
                });
                updateDerived();
                syncMagicOptions();
            };

            const saveLocal = () => {
                const allSheets = JSON.parse(localStorage.getItem('dnd5e-sheets') || '[]');
                const data = getFormData();
                data.meta = data.meta || {};
                data.meta.savedAt = new Date().toISOString();
                allSheets.push(data);
                localStorage.setItem('dnd5e-sheets', JSON.stringify(allSheets));
                setStatus('Ficha salva no navegador.');
            };

            const autosave = () => {
                const data = getFormData();
                data.meta = data.meta || {};
                data.meta.savedAt = new Date().toISOString();
                localStorage.setItem('dnd5e-sheet-draft', JSON.stringify(data));
            };

            const loadDraft = () => {
                const raw = localStorage.getItem('dnd5e-sheet-draft');
                if (!raw) {
                    return;
                }
                try {
                    const data = JSON.parse(raw);
                    applyFormData(data);
                    setStatus('Rascunho recuperado do navegador.');
                } catch (error) {
                    setStatus('Não foi possível recuperar o rascunho.', true);
                }
            };

            const loadLocal = () => {
                const allSheets = JSON.parse(localStorage.getItem('dnd5e-sheets') || '[]');
                if (!allSheets.length) {
                    setStatus('Nenhuma ficha encontrada no navegador.', true);
                    return;
                }
                const last = allSheets[allSheets.length - 1];
                applyFormData(last);
                setStatus('Ficha carregada do navegador.');
            };

            const downloadJson = () => {
                const data = getFormData();
                const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                const name = data?.identity?.name || 'personagem';
                link.href = url;
                link.download = `${name}-dnd5e.json`;
                link.click();
                URL.revokeObjectURL(url);
                setStatus('Download do JSON iniciado.');
            };

            const saveServer = async () => {
                const data = getFormData();
                const form = new FormData();
                form.append('action', 'dnd5e_save_sheet');
                form.append('nonce', root.dataset.nonce);
                form.append('name', data?.identity?.name || 'personagem');
                form.append('json', JSON.stringify(data));

                try {
                    const response = await fetch(root.dataset.ajax, {
                        method: 'POST',
                        body: form,
                        credentials: 'same-origin',
                    });
                    const result = await response.json();
                    if (result.success) {
                        setStatus(`Arquivo salvo: ${result.data.file}`);
                    } else {
                        setStatus(result.data?.message || 'Erro ao salvar no servidor.', true);
                    }
                } catch (error) {
                    setStatus('Falha de rede ao salvar no servidor.', true);
                }
            };

            const importJson = () => {
                const input = root.querySelector('[data-action="import-file"]');
                if (input) {
                    input.click();
                }
            };

            let autosaveTimer;
            root.addEventListener('input', (event) => {
                if (event.target.matches('input, textarea, select')) {
                    updateDerived();
                    clearTimeout(autosaveTimer);
                    autosaveTimer = setTimeout(autosave, 300);
                }
            });

            root.querySelector('[data-action="save-local"]').addEventListener('click', saveLocal);
            root.querySelector('[data-action="load-local"]').addEventListener('click', loadLocal);
            root.querySelector('[data-action="download-json"]').addEventListener('click', downloadJson);
            root.querySelector('[data-action="import-json"]').addEventListener('click', importJson);
            root.querySelector('[data-action="save-server"]').addEventListener('click', saveServer);
            const importInput = root.querySelector('[data-action="import-file"]');
            if (importInput) {
                importInput.addEventListener('change', (event) => {
                    const file = event.target.files && event.target.files[0];
                    if (!file) {
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = () => {
                        try {
                            const data = JSON.parse(reader.result);
                            applyFormData(data);
                            setStatus('Ficha importada do JSON.');
                        } catch (error) {
                            setStatus('JSON inválido para importação.', true);
                        }
                    };
                    reader.onerror = () => {
                        setStatus('Falha ao ler o arquivo JSON.', true);
                    };
                    reader.readAsText(file);
                    event.target.value = '';
                });
            }
            if (addAttackButton) {
                addAttackButton.addEventListener('click', () => {
                    const index = getNextAttackIndex();
                    createAttackBlock(index);
                });
            }

            const syncMagicOptions = () => {
                const options = root.querySelectorAll('[data-option]');
                options.forEach((option) => {
                    const toggle = option.querySelector('[data-option-toggle]');
                    if (!toggle) {
                        return;
                    }
                    option.classList.toggle('is-active', toggle.checked);
                });
            };

            root.querySelectorAll('[data-option-toggle]').forEach((toggle) => {
                toggle.addEventListener('change', syncMagicOptions);
            });

            loadDraft();
            updateDerived();
            syncMagicOptions();
            ensureDefaultAttack();
        })();
    </script>
    <?php
    return ob_get_clean();
}

add_shortcode('dnd5e_sheet', 'dnd5e_sheet_shortcode');

function dnd5e_save_sheet(): void
{
    check_ajax_referer('dnd5e_sheet', 'nonce');

    $json = isset($_POST['json']) ? wp_unslash($_POST['json']) : '';
    $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : 'personagem';
    $decoded = json_decode($json, true);

    if (!$decoded) {
        wp_send_json_error(['message' => 'JSON inválido.']);
    }

    $upload_dir = wp_upload_dir();
    $target_dir = trailingslashit($upload_dir['basedir']) . 'dnd5e-sheets';

    if (!wp_mkdir_p($target_dir)) {
        wp_send_json_error(['message' => 'Não foi possível criar a pasta de upload.']);
    }

    $filename = sanitize_file_name($name . '-' . gmdate('Ymd-His') . '.json');
    $filepath = trailingslashit($target_dir) . $filename;
    $written = file_put_contents($filepath, wp_json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    if ($written === false) {
        wp_send_json_error(['message' => 'Não foi possível salvar o arquivo.']);
    }

    $url = trailingslashit($upload_dir['baseurl']) . 'dnd5e-sheets/' . $filename;
    wp_send_json_success(['file' => $filename, 'url' => $url]);
}

add_action('wp_ajax_dnd5e_save_sheet', 'dnd5e_save_sheet');
add_action('wp_ajax_nopriv_dnd5e_save_sheet', 'dnd5e_save_sheet');
