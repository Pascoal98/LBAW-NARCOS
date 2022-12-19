$('#topics').select2({
    multiple: true,
    maximumSelectionLength: 3,
    tokenSeparators: [',', ' ', ";"],
    theme: "bootstrap-5",
    closeOnSelect: false,
});

$('#filterTopics').select2({
    multiple: true,
    width: '25%',
    tokenSeparators: [',', ' ', ";"],
    theme: "bootstrap-5",
    placeholder: "Filter by Tags",
    closeOnSelect: false,
});

$('#favoriteTopics').select2({
    multiple: true,
    tokenSeparators: [',', ' ', ";"],
    theme: "bootstrap-5",
    closeOnSelect: false,
});
