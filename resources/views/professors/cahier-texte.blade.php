@extends('layouts.dashboard')

@section('title', 'Cahier de Texte')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="header-wrapper">
            <div class="header-content">
                <h1>Cahier de Texte</h1>
                <p class="text-subtitle">Gérez vos notes de cours et le suivi pédagogique</p>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <!-- Formulaire de création/édition -->
        <div class="content-card editor-section">
            <div class="card-header">
                <h2>Édition du cahier</h2>
            </div>
            <div class="card-body">
                <div id="status-message"></div>

                <form id="cahier-texte-form" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="course_id">Cours</label>
                        <div class="select-wrapper">
                            <select name="course_id" id="course_id" class="form-control" required>
                                <option value="">Sélectionner un cours</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ $selectedCourseId == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }} ({{ $course->classe->name }})
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="date">Date du cours</label>
                        <div class="input-icon-wrapper">
                            <input type="date" name="date" id="date" class="form-control" value="{{ $selectedDate ?? date('Y-m-d') }}" required>
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content">Contenu du cours</label>
                        <textarea 
                            name="content" 
                            id="content" 
                            class="form-control editor"
                            style="visibility: hidden"
                        >{{ $content }}</textarea>
                        <div class="invalid-feedback">
                            Veuillez saisir le contenu du cours
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" id="save-btn" class="btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des cahiers -->
        <div class="content-card history-section">
            <div class="card-header">
                <h2>Historique récent</h2>
                <div class="filters">
                    <div class="select-wrapper compact">
                        <select id="filter-course" class="form-control">
                            <option value="">Tous les cours</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-filter"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="cahier-list">
                    @forelse($cahierTextes as $cahier)
                        <div class="cahier-item" data-course-id="{{ $cahier->course_id }}">
                            <div class="cahier-header">
                                <div class="cahier-info">
                                    <h3>{{ $cahier->course->title }}</h3>
                                    <span class="cahier-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $cahier->date->format('d/m/Y') }}
                                    </span>
                                </div>
                                <div class="cahier-meta">
                                    <span class="badge badge-class">
                                        <i class="fas fa-users"></i>
                                        {{ $cahier->course->classe->name }}
                                    </span>
                                    <span class="badge badge-subject">
                                        <i class="fas fa-book"></i>
                                        {{ $cahier->course->subject->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="cahier-content">
                                {!! $cahier->content !!}
                            </div>
                            <div class="cahier-actions">
                                <button class="btn-icon edit" onclick="editCahier('{{ $cahier->course_id }}', '{{ $cahier->date->format('Y-m-d') }}')" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-book"></i>
                            <p>Aucun cahier de texte enregistré</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le cahier de texte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-cahier-form">
                    @csrf
                    <input type="hidden" id="edit_course_id" name="course_id">
                    <input type="hidden" id="edit_date" name="date">
                    
                    <div class="form-group">
                        <label>Cours</label>
                        <p id="edit_course_title" class="form-control-static"></p>
                    </div>

                    <div class="form-group">
                        <label>Date</label>
                        <p id="edit_date_display" class="form-control-static"></p>
                    </div>

                    <div class="form-group">
                        <label for="edit_content">Contenu</label>
                        <textarea id="edit_content" name="content" class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="saveEditBtn">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .content-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin-top: 1rem;
    }

    .content-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #E5E7EB;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h2 {
        font-size: 1.25rem;
        color: #1F2937;
        margin: 0;
        font-weight: 600;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #374151;
    }

    .select-wrapper {
        position: relative;
    }

    .select-wrapper i {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6B7280;
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #E5E7EB;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
        outline: none;
    }

    /* Editor Section */
    .editor-section .form-control {
        min-height: 200px;
    }

    /* History Section */
    .cahier-list {
        display: grid;
        gap: 1rem;
    }

    .cahier-item {
        padding: 1.25rem;
        border: 1px solid #E5E7EB;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .cahier-item:hover {
        border-color: var(--primary);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .cahier-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .cahier-info h3 {
        margin: 0 0 0.5rem 0;
        font-size: 1.1rem;
        color: #1F2937;
    }

    .cahier-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6B7280;
        font-size: 0.875rem;
    }

    .cahier-meta {
        display: flex;
        gap: 0.5rem;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .badge-class {
        background-color: #EEF2FF;
        color: #4F46E5;
    }

    .badge-subject {
        background-color: #F0FDF4;
        color: #15803D;
    }

    .cahier-content {
        color: #4B5563;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        max-height: 100px;
        overflow-y: auto;
    }

    .btn-icon {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 0.5rem;
        background: #EEF2FF;
        color: #4F46E5;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        background: #4F46E5;
        color: white;
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #6B7280;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #9CA3AF;
    }

    /* Alert Styles */
    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
    }

    .alert-success {
        background-color: #DEF7EC;
        color: #03543F;
        border: 1px solid #84E1BC;
    }

    .alert-danger {
        background-color: #FDE8E8;
        color: #9B1C1C;
        border: 1px solid #F8B4B4;
    }

    .alert-info {
        background-color: #E1EFFE;
        color: #1E429F;
        border: 1px solid #A4CAFE;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal.show {
        display: block;
    }

    .modal-dialog {
        position: relative;
        width: 90%;
        max-width: 800px;
        margin: 2rem auto;
    }

    .modal-content {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #E5E7EB;
    }

    .modal-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #E5E7EB;
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
    }

    .form-control-static {
        padding: 0.75rem;
        background: #F3F4F6;
        border-radius: 0.375rem;
        margin: 0;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
    let editor;
    let editEditor;

    // Attendre que CKEditor soit complètement chargé
    function initializeEditor() {
        return ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                language: 'fr'
            })
            .then(newEditor => {
                editor = newEditor;

                // Gérer la validation personnalisée
                editor.model.document.on('change:data', () => {
                    const data = editor.getData();
                    const contentInput = document.querySelector('#content');
                    if (data) {
                        contentInput.setCustomValidity('');
                    } else {
                        contentInput.setCustomValidity('Ce champ est requis');
                    }
                });
            });
    }

    // Fonction pour soumettre le formulaire
    async function submitForm(form, editor, saveBtn, statusMsg) {
        try {
            const courseId = document.getElementById('course_id').value;
            const date = document.getElementById('date').value;
            const content = editor.getData();

            if (!courseId || !date) {
                alert('Veuillez sélectionner un cours et une date');
                return;
            }

            if (!content.trim()) {
                alert('Le contenu ne peut pas être vide');
                return;
            }

            saveBtn.disabled = true;
            statusMsg.textContent = 'Sauvegarde en cours...';
            statusMsg.className = 'alert alert-info';

            const response = await fetch('{{ route("professor.cahier-texte") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    course_id: courseId,
                    date: date,
                    content: content
                })
            });

            const data = await response.json();

            if (data.success) {
                statusMsg.textContent = 'Sauvegardé avec succès!';
                statusMsg.className = 'alert alert-success';
                setTimeout(() => window.location.reload(), 1000);
            } else {
                throw new Error(data.message || 'Erreur lors de la sauvegarde');
            }
        } catch (error) {
            console.error('Erreur:', error);
            statusMsg.textContent = error.message;
            statusMsg.className = 'alert alert-danger';
        } finally {
            saveBtn.disabled = false;
        }
    }

    document.addEventListener('DOMContentLoaded', async function() {
        const form = document.getElementById('cahier-texte-form');
        const saveBtn = document.getElementById('save-btn');
        const statusMsg = document.getElementById('status-message');

        try {
            await initializeEditor();
            console.log('CKEditor initialisé avec succès');

            // Gérer la soumission du formulaire
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                if (editor) {
                    await submitForm(form, editor, saveBtn, statusMsg);
                }
            });

            // Charger le contenu initial si nécessaire
            const courseId = document.getElementById('course_id').value;
            const date = document.getElementById('date').value;
            if (courseId && date) {
                loadCahierTexteContent();
            }

            // Écouter les changements
            document.getElementById('course_id').addEventListener('change', loadCahierTexteContent);
            document.getElementById('date').addEventListener('change', loadCahierTexteContent);

        } catch (error) {
            console.error('Erreur d\'initialisation:', error);
            statusMsg.textContent = 'Erreur lors de l\'initialisation de l\'éditeur';
            statusMsg.className = 'alert alert-danger';
        }
    });

    // Fonction pour charger le contenu
    async function loadCahierTexteContent() {
        if (!editor) return;

        const courseId = document.getElementById('course_id').value;
        const date = document.getElementById('date').value;
        
        if (!courseId || !date) return;

        try {
            const response = await fetch(`/professor/cahier-texte/content?course_id=${courseId}&date=${date}`);
            const data = await response.json();
            editor.setData(data.content || '');
        } catch (error) {
            console.error('Erreur chargement:', error);
        }
    }

    // Fonction pour ouvrir le modal
    function editCahier(courseId, date) {
        const modal = document.getElementById('editModal');
        const courseSelect = document.getElementById('course_id');
        const course = Array.from(courseSelect.options).find(option => option.value === courseId);

        document.getElementById('edit_course_id').value = courseId;
        document.getElementById('edit_date').value = date;
        document.getElementById('edit_course_title').textContent = course.text;
        document.getElementById('edit_date_display').textContent = new Date(date).toLocaleDateString('fr-FR');

        // Charger le contenu existant
        fetch(`/professor/cahier-texte/content?course_id=${courseId}&date=${date}`)
            .then(response => response.json())
            .then(data => {
                editEditor.setData(data.content || '');
                modal.classList.add('show');
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    }

    // Initialisation
    document.addEventListener('DOMContentLoaded', async function() {
        // ... code existant ...

        // Initialiser CKEditor pour le modal
        ClassicEditor
            .create(document.querySelector('#edit_content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                language: 'fr'
            })
            .then(newEditor => {
                editEditor = newEditor;
            });

        // Gérer la fermeture du modal
        document.querySelector('.close').addEventListener('click', () => {
            document.getElementById('editModal').classList.remove('show');
        });

        // Gérer la sauvegarde des modifications
        document.getElementById('saveEditBtn').addEventListener('click', async () => {
            const courseId = document.getElementById('edit_course_id').value;
            const date = document.getElementById('edit_date').value;
            const content = editEditor.getData();

            try {
                const response = await fetch('{{ route("professor.cahier-texte") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        course_id: courseId,
                        date: date,
                        content: content
                    })
                });

                const data = await response.json();

                if (data.success) {
                    window.location.reload();
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur lors de la sauvegarde: ' + error.message);
            }
        });
    });
</script>
@endpush
@endsection 