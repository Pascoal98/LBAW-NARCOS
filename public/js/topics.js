proposeTopic = (e) => {
    e.preventDefault();
    const topicName = e.target.elements.topicName.value;
    sendAjaxRequest('post', '/topics/new', { topicName }, proposeTopicHandler);
}

function proposeTopicHandler() {
    if (this.status == 403) {
        window.location = '/login';
        return;
    }

    const previousError = select('#proposeTopic .error');

    if (this.status == 400) {
        const error = createErrorMessage(JSON.parse(this.responseText).errors);

        if (previousError)
            previousError.replaceWith(error);
        else
            select('#proposeTopic').appendChild(error);

        return;
    }

    if (previousError) previousError.remove();
    const confirmation = document.createElement('h4');
    confirmation.classList.add('mb-0');
    confirmation.innerHTML = 'Thank you for your contribution!';

    select('#proposeTopicForm').replaceWith(confirmation);
}


acceptTopic = (elem, id) => {
    const url = '/topics/'+ id + '/accept';
    sendAjaxRequest('put', url, null, topicHandler(elem, id, "accept"));
}

rejectTopic = (elem, id) =>  {
    const url = '/topics/'+ id + '/reject';
    sendAjaxRequest('put', url, null, topicHandler(elem, id, "reject"));
}

removeTopic = (elem, id) =>  {
    const url = '/topics/'+ id;
    sendAjaxRequest('delete', url, null, topicHandler(elem, id, "remove"));
}

const topicHandler = (elem, id, action) => function() {
    if (this.status == 403) {
        window.location = '/login';
        return;
    }

    const previousError = elem.querySelector('.error');

    if (this.status == 400) {
        const error = createErrorMessage(JSON.parse(this.responseText).errors);

        if (previousError)
            previousError.replaceWith(error);
        else
            elem.appendChild(error);

        return;
    }

    if (action !== "remove") {
        const accept = (btn, id) => { removeTopic(btn, id); };
        const remove = (btn, id) => { acceptTopic(btn, id); };
        let icon, color, containerId, func;
        if (action === "accept") {
            icon = "fa-trash";
            color = "text-danger";
            containerId = `#acceptedTopicsContainer`;
            func = accept;
        } else {
            icon = "fa-check";
            color = "text-success";
            containerId = `#rejectTopicsContainer`
            func = remove;
        }

        replaceTopicContainer(this.responseText, func, id, icon, color, containerId);
    }

    if (previousError) previousError.remove();

    const confirmation = document.createElement('h4');
    confirmation.classList.add('mb-0');
    confirmation.innerHTML = JSON.parse(this.responseText).msg;

    elem.parentElement.replaceWith(confirmation);
}


function replaceTopicContainer(responseText, btnFunction, id, icon, iconColor, containerId) {
    const topicContainer = document.createElement('div');
    topicContainer.classList.add("y-5", "pb-3", "pt-5", "bg-dark", "manageTopicContainer");

    const subdiv = document.createElement('div');
    subdiv.id = "stateButton";
    subdiv.classList.add("d-flex", "align-items-center");
    
    const topic = document.createElement("h5");
    topic.classList.add("mx-3", "my-0", "py-0", "w-75");
    topic.innerHTML = JSON.parse(responseText).topic_name;

    const btn = document.createElement("button");
    btn.type = "button";
    btn.onclick = () => { btnFunction(btn, id);};
    btn.classList.add("my-0", "py-0", "btn", "btn-lg", "btn-transparent");

    const iter = document.createElement("i");
    iter.classList.add("fas", icon, "fa-2x", "mb-2", iconColor);

    btn.appendChild(iter);
    subdiv.appendChild(topic);
    subdiv.appendChild(btn);
    topicContainer.appendChild(subdiv);

    const container = select(containerId);
    container.appendChild(topicContainer);

    return container;
}