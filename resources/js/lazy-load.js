// Create an intersection observer instance
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            loadMoreProjects();
        }
    });
});

// Observe the sentinel element
const sentinel = document.getElementById("sentinel");
observer.observe(sentinel);

let page = 2; // Start from the next page

function loadMoreProjects() {
    // Make an AJAX request to fetch the next page of projects
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "{{ route('projects.index') }} ?page=" + page);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            const projects = data.projects;

            // Append the new projects to the projects container
            const projectsContainer =
                document.getElementById("projectsContainer");
            projects.forEach((project) => {
                const projectElement = document.createElement("p");
                projectElement.textContent = project.name;
                projectsContainer.appendChild(projectElement);
            });

            // Increment the page counter for the next load
            page++;

            // Disconnect the observer if there are no more projects
            if (!data.has_more) {
                observer.disconnect();
            }
        }
    };
    xhr.send();
}
