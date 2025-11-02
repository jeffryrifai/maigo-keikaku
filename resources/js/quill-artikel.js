import Quill from "quill";
import "quill/dist/quill.snow.css";

let quill;

export function loadQuill() {
    const editorEl = document.getElementById("editor");
    if (!editorEl) return;

    // ambil konten awal dari Livewire (kalau ada)
    let currentContent = safeJsonParse(editorEl.dataset.content_delta);

    // kalau sebelumnya sudah ada instance, hancurkan dulu
    if (editorEl.__quill) destroyQuill();

    const options = {
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ["bold", "italic", "underline"],
                ["link"],
                [{ list: "ordered" }, { list: "bullet" }],
            ],
        },
        placeholder: "Tulis isi artikel...",
        theme: "snow",
    };

    quill = new Quill(editorEl, options);

    // kalau ada konten awal dari Livewire, isi ke editor
    if (currentContent && typeof currentContent === "object") {
        quill.setContents(currentContent);
    }

    // update Livewire saat form disubmit
    const form = editorEl.closest("form");
    form.addEventListener("submit", () => {
        const html = quill.root.innerHTML.trim();
        const delta = JSON.stringify(quill.getContents());

        const component = Livewire.find(
            form.closest("[wire\\:id]").getAttribute("wire:id")
        );
        component.set("content", html);
        component.set("content_delta", delta);
    });

    // simpan instance agar bisa di-destroy
    editorEl.__quill = quill;

    // update dari Livewire (misal setelah reset)
    Livewire.on("refreshQuill", (delta) => {
        quill.setContents(safeJsonParse(delta));
    });
}

export function destroyQuill() {
    const editorEl = document.getElementById("editor");
    if (!editorEl || !editorEl.__quill) return;

    const quill = editorEl.__quill;

    // bersihkan event
    quill.off("text-change");

    // hapus toolbar
    const toolbar = editorEl.parentElement.querySelector(".ql-toolbar");
    if (toolbar) toolbar.remove();

    // kosongkan isi
    editorEl.innerHTML = "";

    delete editorEl.__quill;
}

// helper aman untuk JSON.parse
function safeJsonParse(value) {
    try {
        return JSON.parse(value);
    } catch {
        return value;
    }
}
